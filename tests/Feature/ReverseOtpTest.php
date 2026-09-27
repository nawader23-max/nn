<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReverseOtpTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config()->set('reverse_otp.enabled', true);
        config()->set('reverse_otp.cache_store', 'array');
        config()->set('reverse_otp.whatsapp_number', '966500000000');
        config()->set('reverse_otp.sms_number', '966500000000');
    }

    public function test_verified_phone_can_start_a_browser_bound_challenge(): void
    {
        User::factory()->create([
            'phone_e164' => '+966500000000',
            'phone_verified_at' => now(),
            'role' => 'corporate_client',
            'two_factor_enabled' => false,
        ]);

        $response = $this->withSession(['_token' => 'test-csrf'])
            ->withHeader('X-CSRF-TOKEN', 'test-csrf')
            ->postJson('/api/auth/reverse-otp/generate', ['phone' => '0500000000']);

        $response->assertOk()->assertJsonStructure(['token', 'expires_at', 'whatsapp_url', 'sms_url']);
        $this->assertMatchesRegularExpression('/^NAWADER-[A-Z0-9]{10}$/', (string) $response->json('token'));
    }

    public function test_unverified_or_unknown_phone_cannot_start_login_challenge(): void
    {
        $before = User::count();
        $response = $this->withSession(['_token' => 'test-csrf'])
            ->withHeader('X-CSRF-TOKEN', 'test-csrf')
            ->postJson('/api/auth/reverse-otp/generate', ['phone' => '0500000000']);

        $response->assertUnprocessable();
        $this->assertSame($before, User::count());
    }
}
