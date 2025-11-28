<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_redirects_when_branding_disabled(): void
    {
        config(['tms.branding' => '0']);

        $response = $this->get('/register');

        $response->assertRedirect('/login');
    }

    public function test_registration_page_accessible_when_branding_enabled(): void
    {
        config(['tms.branding' => '1']);

        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_user_can_register_when_branding_enabled(): void
    {
        config(['tms.branding' => '1']);

        $response = $this->post('/register', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
            'name' => 'New User',
        ]);

        $response->assertRedirect('/app');
    }

    public function test_user_cannot_register_when_branding_disabled(): void
    {
        config(['tms.branding' => '0']);

        $response = $this->post('/register', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => 'newuser@example.com',
        ]);

        $response->assertRedirect('/login');
    }
}
