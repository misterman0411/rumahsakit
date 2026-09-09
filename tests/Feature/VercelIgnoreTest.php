<?php

namespace Tests\Feature;

use Tests\TestCase;

class VercelIgnoreTest extends TestCase
{
    public function test_vercel_ignore_does_not_exclude_vendor_dependencies(): void
    {
        $vercelIgnore = file_get_contents(base_path('.vercelignore'));

        $this->assertStringNotContainsString("/vendor", $vercelIgnore);
        $this->assertStringNotContainsString("vendor", $vercelIgnore);
    }
}
