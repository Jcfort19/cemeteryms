<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CemeteryMsSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_core_web_modules_render_for_semi_admin(): void
    {
        $this->seed();

        $admin = User::where('email', 'admin@cemeteryms.test')->firstOrFail();

        foreach (['/dashboard', '/clients', '/cemetery-map', '/billing', '/payments', '/reports'] as $uri) {
            $this->actingAs($admin)->get($uri)->assertOk();
        }
    }

    public function test_collector_api_login_returns_token(): void
    {
        $this->seed();

        $this->postJson('/api/collector/login', [
            'email' => 'collector@cemeteryms.test',
            'password' => 'password',
            'device_id' => 'test-device',
        ])->assertOk()->assertJsonStructure(['token', 'collector']);
    }
}
