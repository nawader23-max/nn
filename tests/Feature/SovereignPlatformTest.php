<?php

namespace Tests\Feature;

use App\Models\DigitalContract;
use App\Models\IntegrationSetting;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Services\ContentBlockService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class SovereignPlatformTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_sovereign_routes(): void
    {
        $routes = [
            '/',
            '/services',
            '/pricing',
            '/about',
            '/contact',
            '/help',
            '/help/saudi-misa-license',
            '/privacy',
            '/terms',
            '/refund',
            '/studio',
            '/services/app-builder',
            '/login',
            '/register',
            '/register/verify',
            '/forgot-password',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    public function test_services_hierarchical_drilldown(): void
    {
        // Category
        $response = $this->get('/services/legal');
        $response->assertStatus(200);

        // Subcategory
        $response = $this->get('/services/legal/llc');
        $response->assertStatus(200);

        // Service
        $response = $this->get('/services/legal/llc/saudi-llc');
        $response->assertStatus(200);
    }

    public function test_authenticated_dashboard_routes(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $operation = ServiceRequest::create([
            'request_number' => 'NW-RQ-TEST-001',
            'user_id' => $user->id,
            'category' => 'legal',
            'service_name' => 'طلب اختبار',
            'entity_name' => 'كيان اختبار',
            'speed' => 'standard',
            'submitted_at' => now(),
        ]);

        $routes = [
            '/dashboard',
            '/dashboard/overview',
            '/dashboard/profile',
            '/dashboard/notifications',
            '/dashboard/settings',
            '/dashboard/wallet',
            '/dashboard/contracts',
            '/dashboard/loyalty',
            '/dashboard/integrations',
            '/dashboard/affiliate',
            '/dashboard/developer',
            '/dashboard/ai-studio',
            '/dashboard/requests',
            '/dashboard/requests/new',
            "/dashboard/requests/{$operation->request_number}",
            "/dashboard/requests/{$operation->request_number}/track",
            '/dashboard/payments',
            '/dashboard/invoices/INV-2024-001',
            '/dashboard/messages',
            '/dashboard/documents',
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($user)->get($route);
            $response->assertStatus(200);
        }
    }

    public function test_authenticated_investor_portal_routes(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $routes = [
            '/investor',
            '/investor/opportunities',
            '/investor/opportunities/NW-OPP-901',
            '/investor/data-room',
            '/investor/consultations',
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($user)->get($route);
            $response->assertStatus(200);
        }
    }

    public function test_client_request_is_persisted_and_scoped_to_its_owner(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($owner)->post('/dashboard/requests/new', [
            'category' => 'legal',
            'service_name' => 'خدمة اختبار',
            'entity_name' => 'منشأة اختبار',
            'target_market' => 'saudi',
            'speed' => 'standard',
            'notes' => 'تفاصيل طلب الاختبار',
        ])->assertRedirect();

        $operation = ServiceRequest::where('user_id', $owner->id)->firstOrFail();
        $this->assertSame('submitted', $operation->status);
        $this->assertDatabaseHas('user_notifications', [
            'user_id' => $owner->id,
            'type' => 'success',
        ]);

        $this->actingAs($otherUser)
            ->get("/dashboard/requests/{$operation->request_number}")
            ->assertNotFound();
    }

    public function test_contract_electronic_signing(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $contract = DigitalContract::create([
            'contract_number' => 'NW-CNT-TEST-001',
            'user_id' => $user->id,
            'title' => 'عقد شراكة استثمارية تجريبي',
            'entity_name' => 'شركة تجريبية',
            'contract_type' => 'bilateral_jv',
            'status' => 'pending_signature',
        ]);

        $response = $this->actingAs($user)->post("/dashboard/contracts/{$contract->id}/sign");
        $response->assertRedirect();

        $contract->refresh();
        $this->assertEquals('active', $contract->status);
        $this->assertNotNull($contract->signature_hash);
    }

    public function test_integrations_key_saving(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['role' => 'super_admin']);

        $response = $this->actingAs($user)->post('/dashboard/integrations/key', [
            'provider' => 'openai',
            'key' => 'api_key',
            'value' => 'sk-test-secret-key-12345',
            'group' => 'ai',
        ]);

        $response->assertRedirect();

        // The value is stored encrypted via the EncryptedString cast — verify
        // the row exists and decrypts back to the original secret.
        $this->assertDatabaseHas('integration_settings', [
            'provider' => 'openai',
            'key' => 'api_key',
        ]);

        $stored = IntegrationSetting::where('provider', 'openai')->where('key', 'api_key')->first();
        $this->assertNotNull($stored);
        $this->assertSame('sk-test-secret-key-12345', $stored->value);
        $this->assertNotSame('sk-test-secret-key-12345', (string) $stored->getRawOriginal('value'));
    }

    public function test_ai_chat_and_search_endpoints(): void
    {
        // Chat endpoint with persona
        $response = $this->postJson('/api/ai/chat', [
            'message' => 'ما هي متطلبات تأسيس شركة في ديلاوير؟',
            'persona' => 'legal',
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['response', 'provider', 'model']);

        // HR Persona test
        $hrResponse = $this->postJson('/api/ai/chat', [
            'message' => 'كيف أحافظ على النطاق الأخضر في قوى؟',
            'persona' => 'hr',
        ]);
        $hrResponse->assertStatus(200);

        // Search endpoint
        $searchRes = $this->getJson('/api/ai/search?q=تأسيس');
        $searchRes->assertStatus(200);
        $searchRes->assertJsonStructure(['results']);
    }

    public function test_ai_studio_generation_action(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/dashboard/ai-studio/generate', [
            'type' => 'legal_draft',
            'prompt' => 'صياغة عقد استشاري هندسي لمشروع نيوم أوكساجون مع شرط التحكيم لدى SCCA',
            'party_a' => 'مجموعة نوادر للخدمات السيادية',
            'party_b' => 'شركة المقاولات الهندسية',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('ai_studio_generations', [
            'type' => 'legal_draft',
            'user_id' => $user->id,
        ]);
    }

    public function test_developer_token_creation(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['role' => 'developer']);

        $response = $this->actingAs($user)->post('/dashboard/developer/token', [
            'name' => 'Aramco ERP Integration Test',
            'environment' => 'live',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('developer_api_tokens', [
            'user_id' => $user->id,
            'name' => 'Aramco ERP Integration Test',
            'environment' => 'live',
        ]);
    }

    public function test_affiliate_referral_tracking(): void
    {
        $response = $this->get('/ref/NWDR-KAFD-901');
        $response->assertRedirect('/');
        $response->assertCookie('nawader_ref', 'NWDR-KAFD-901');
    }

    public function test_visual_editor_page_and_save_action(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['role' => 'super_admin']);

        // 1. View Editor Interface
        $response = $this->actingAs($user)->get('/dashboard/editor?page=home');
        $response->assertStatus(200);
        $response->assertSee('محرر الصفحات والمحتوى السيادي الحي');

        // 2. Save Custom Content Block via Ajax
        $saveResponse = $this->actingAs($user)->postJson('/dashboard/editor/save', [
            'page' => 'home',
            'fields' => [
                'hero_title' => 'بوابتك السيادية نحو العالمية 2030',
                'hero_badge' => '🌟 الشراكة الاستراتيجية العليا',
            ],
        ]);
        $saveResponse->assertStatus(200);
        $saveResponse->assertJson(['status' => 'success']);

        $this->assertEquals(
            'بوابتك السيادية نحو العالمية 2030',
            ContentBlockService::get('home', 'hero_title')
        );

        // 3. Export content blocks
        $exportResponse = $this->actingAs($user)->get('/dashboard/editor/export');
        $exportResponse->assertStatus(200);
        $exportResponse->assertHeader('content-type', 'application/json');
    }

    public function test_document_ingestion_and_archive_upload(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['role' => 'super_admin']);

        // 1. View Importer Interface
        $response = $this->actingAs($user)->get('/dashboard/importer');
        $response->assertStatus(200);
        $response->assertSee('محرك استيعاب الوثائق وفك الأرشيفات الكبرى');

        // 2. Create a synthetic test ZIP archive in memory/temp
        $tempZipPath = tempnam(sys_get_temp_dir(), 'nwdr_zip_');
        $zip = new \ZipArchive;
        $zip->open($tempZipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $zip->addFromString('عقد_شراكة_توريد_نيوم.txt', 'اتفاقية وعقد توريد هندسي سيادي مع شرط التحكيم التجاري لدى SCCA ومبلغ 500,000 ر.س');
        $zip->addFromString('فاتورة_سداد_رسوم_اعتماد.txt', 'فاتورة سداد إلكتروني معتمدة برقم مرجعي وضريبة القيمة المضافة 15,000 ر.س');
        $zip->close();

        $uploadedFile = new UploadedFile(
            $tempZipPath,
            'sovereign_archive_test.zip',
            'application/zip',
            null,
            true
        );

        $uploadResponse = $this->actingAs($user)->post('/dashboard/importer/upload', [
            'archive_file' => $uploadedFile,
        ]);

        $uploadResponse->assertRedirect(route('dashboard.importer'));

        // Assert contract was extracted and recorded
        $this->assertDatabaseHas('digital_contracts', [
            'currency' => 'SAR',
            'status' => 'signed',
        ]);

        // Assert financial transaction was recorded
        $this->assertDatabaseHas('wallet_transactions', [
            'type' => 'credit',
            'currency' => 'SAR',
        ]);

        // 3. Export CSV and ZIP reports
        $contractsCsv = $this->actingAs($user)->get('/dashboard/importer/export?type=contracts');
        $contractsCsv->assertStatus(200);

        $allZip = $this->actingAs($user)->get('/dashboard/importer/export?type=all_zip');
        $allZip->assertStatus(200);
    }
}
