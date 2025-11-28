<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // With APP_BRANDING=0, landing page redirects to /app
        config(['tms.branding' => '1']);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
