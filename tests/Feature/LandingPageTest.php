<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_landing_page_redirects_to_app_when_branding_disabled(): void
    {
        config(['tms.branding' => '0']);

        $response = $this->get('/');

        $response->assertRedirect('/app');
    }

    public function test_landing_page_displays_when_branding_enabled(): void
    {
        config(['tms.branding' => '1']);

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_privacy_policy_page_accessible(): void
    {
        $response = $this->get('/privacypolicy');

        $response->assertStatus(200);
    }
}
