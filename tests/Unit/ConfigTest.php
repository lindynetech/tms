<?php

namespace Tests\Unit;

use Tests\TestCase;

class ConfigTest extends TestCase
{
    public function test_app_branding_config_exists(): void
    {
        $branding = config('tms.branding');

        $this->assertNotNull($branding);
        $this->assertContains($branding, ['0', '1']);
    }

    public function test_app_has_required_config_values(): void
    {
        $this->assertNotEmpty(config('app.name'));
        $this->assertNotEmpty(config('app.url'));
        $this->assertNotEmpty(config('tms.title'));
    }

    public function test_database_connection_is_configured(): void
    {
        $this->assertNotEmpty(config('database.default'));
        $this->assertNotEmpty(config('database.connections.mysql'));
    }

    public function test_mail_configuration_exists(): void
    {
        $this->assertNotEmpty(config('mail.mailers.smtp'));
        $this->assertNotEmpty(config('mail.from.address'));
    }
}
