<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_app(): void
    {
        $response = $this->get('/app');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_app(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'status' => 1
        ]);

        $response = $this->actingAs($user)->get('/app');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_access_goals(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'status' => 1
        ]);

        $response = $this->actingAs($user)->get('/goals');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_access_reading_list(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'status' => 1
        ]);

        $response = $this->actingAs($user)->get('/readinglist');

        $response->assertStatus(200);
    }
}
