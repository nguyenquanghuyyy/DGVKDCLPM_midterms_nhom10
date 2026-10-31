<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class GoogleAuthTest extends TestCase
{
    public function test_google_login_redirects_to_google_with_the_configured_callback(): void
    {
        config([
            'services.google.client_id' => 'test-client-id',
            'services.google.client_secret' => 'test-client-secret',
            'services.google.redirect' => 'http://127.0.0.1:8000/auth/google/callback',
        ]);

        $response = $this->get(route('auth.google.redirect'));

        $response->assertRedirect();
        $this->assertStringStartsWith('https://accounts.google.com/o/oauth2/v2/auth?', $response->headers->get('Location'));
        $this->assertStringContainsString(
            'redirect_uri=' . urlencode('http://127.0.0.1:8000/auth/google/callback'),
            $response->headers->get('Location')
        );
    }

    public function test_google_login_reports_missing_oauth_credentials(): void
    {
        config([
            'services.google.client_id' => null,
            'services.google.client_secret' => null,
        ]);

        $this->followingRedirects()
            ->get(route('auth.google.redirect'))
            ->assertOk()
            ->assertSee('Chưa cấu hình GOOGLE_CLIENT_ID và GOOGLE_CLIENT_SECRET cho đăng nhập Google.');
    }
}
