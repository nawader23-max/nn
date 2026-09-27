<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyPlatformSignature;
use App\Services\ContentBlockService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

/**
 * Guards the signed server-to-server bridge exposed by the main platform:
 *
 *   GET  /api/bridge/v1/ping
 *   GET  /api/bridge/v1/content/blocks
 *   POST /api/bridge/v1/content/sync   (HMAC + timestamp + nonce)
 *   POST /api/bridge/v1/events         (HMAC + timestamp + nonce)
 */
class PlatformBridgeTest extends TestCase
{
    use RefreshDatabase;

    private const SECRET = 'bridge-test-secret-0123456789abcdef';

    private const SYNC_PATH = 'api/bridge/v1/content/sync';

    private const EVENTS_PATH = 'api/bridge/v1/events';

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'platform.secret' => self::SECRET,
            'platform.id' => 'nawadersrv.com',
        ]);

        File::delete(storage_path('app/content_blocks.json'));
    }

    protected function tearDown(): void
    {
        File::delete(storage_path('app/content_blocks.json'));

        parent::tearDown();
    }

    private function signedHeaders(string $method, string $path, string $body, ?string $timestamp = null, ?string $nonce = null): array
    {
        $timestamp ??= (string) now()->getTimestamp();
        $nonce ??= bin2hex(random_bytes(16));

        return [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json',
            'HTTP_X_PLATFORM_ID' => 'travelsstar.net',
            'HTTP_X_PLATFORM_TIMESTAMP' => $timestamp,
            'HTTP_X_PLATFORM_NONCE' => $nonce,
            'HTTP_X_PLATFORM_SIGNATURE' => VerifyPlatformSignature::sign($method, $path, $timestamp, $nonce, $body, self::SECRET),
        ];
    }

    public function test_ping_handshake_is_public_and_never_leaks_secrets(): void
    {
        $response = $this->getJson('/api/bridge/v1/ping');

        $response->assertOk()
            ->assertJsonPath('status', 'operational')
            ->assertJsonPath('platform', 'nawadersrv.com')
            ->assertJsonPath('bridge', 'api/bridge/v1');

        $this->assertStringNotContainsString(self::SECRET, $response->getContent());
    }

    public function test_blocks_route_exposes_the_local_page_store(): void
    {
        ContentBlockService::savePageBlocks('home', ['hero_title' => 'عنوان محلي']);

        $this->getJson('/api/bridge/v1/content/blocks')
            ->assertOk()
            ->assertJsonPath('data.home.hero_title', 'عنوان محلي');
    }

    public function test_signed_sync_writes_page_fields_into_the_store(): void
    {
        $body = json_encode([
            'page' => 'home',
            'fields' => ['hero_title' => 'عنوان من المحور', 'hero_badge' => 'شارة'],
        ], JSON_UNESCAPED_UNICODE);

        $this->call(
            'POST', '/'.self::SYNC_PATH, [], [], [],
            $this->signedHeaders('POST', self::SYNC_PATH, $body),
            $body,
        )
            ->assertOk()
            ->assertJsonPath('applied.home', 2);

        $this->assertSame('عنوان من المحور', ContentBlockService::get('home', 'hero_title'));
    }

    public function test_signed_sync_accepts_hub_block_payload_shape(): void
    {
        $body = json_encode([
            'blocks' => [
                [
                    'key' => 'home.hero',
                    'payload' => ['page' => 'home', 'fields' => ['hero_subtitle' => 'نص من المنصة']],
                ],
            ],
        ], JSON_UNESCAPED_UNICODE);

        $this->call(
            'POST', '/'.self::SYNC_PATH, [], [], [],
            $this->signedHeaders('POST', self::SYNC_PATH, $body),
            $body,
        )->assertOk()->assertJsonPath('applied.home', 1);

        $this->assertSame('نص من المنصة', ContentBlockService::get('home', 'hero_subtitle'));
    }

    public function test_bridge_pushed_copy_renders_on_the_public_home_page(): void
    {
        ContentBlockService::savePageBlocks('home', ['hero_title' => 'عنوان سيادي من المحور']);

        $this->get('/')->assertOk()->assertSee('عنوان سيادي من المحور', false);
    }

    public function test_sync_without_signature_is_rejected(): void
    {
        $body = json_encode(['page' => 'home', 'fields' => ['hero_title' => 'x']]);

        $this->call('POST', '/'.self::SYNC_PATH, [], [], [], ['CONTENT_TYPE' => 'application/json'], $body)
            ->assertStatus(401);
    }

    public function test_stale_timestamp_is_rejected(): void
    {
        $body = json_encode(['page' => 'home', 'fields' => ['hero_title' => 'x']]);

        $this->call(
            'POST', '/'.self::SYNC_PATH, [], [], [],
            $this->signedHeaders('POST', self::SYNC_PATH, $body, (string) now()->subHour()->getTimestamp()),
            $body,
        )->assertStatus(401);
    }

    public function test_replayed_nonce_is_rejected(): void
    {
        $body = json_encode(['page' => 'home', 'fields' => ['hero_title' => 'مرة واحدة']], JSON_UNESCAPED_UNICODE);
        $headers = $this->signedHeaders('POST', self::SYNC_PATH, $body);

        $this->call('POST', '/'.self::SYNC_PATH, [], [], [], $headers, $body)->assertOk();

        $this->call('POST', '/'.self::SYNC_PATH, [], [], [], $headers, $body)
            ->assertStatus(401)
            ->assertJsonPath('error', 'Duplicate bridge nonce (replay detected).');
    }

    public function test_unusable_sync_payload_returns_422(): void
    {
        $body = json_encode(['something' => 'else']);

        $this->call(
            'POST', '/'.self::SYNC_PATH, [], [], [],
            $this->signedHeaders('POST', self::SYNC_PATH, $body),
            $body,
        )->assertStatus(422);
    }

    public function test_signed_event_is_acknowledged(): void
    {
        $body = json_encode(['event' => 'contract.signed', 'payload' => ['id' => 42]]);

        $this->call(
            'POST', '/'.self::EVENTS_PATH, [], [], [],
            $this->signedHeaders('POST', self::EVENTS_PATH, $body),
            $body,
        )
            ->assertOk()
            ->assertJsonPath('received', true)
            ->assertJsonPath('event', 'contract.signed');
    }

    public function test_security_headers_are_present_on_web_responses(): void
    {
        $response = $this->get('/');

        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }
}
