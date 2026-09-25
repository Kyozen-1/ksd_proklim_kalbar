<?php

namespace Tests\Feature;

use Tests\TestCase;

class FaviconConsistencyTest extends TestCase
{
    public function test_every_application_layout_uses_the_shared_favicon(): void
    {
        $layouts = [
            resource_path('views/frontend/layouts/head.blade.php'),
            resource_path('views/auth/login/layouts/head.blade.php'),
            resource_path('views/backend/layouts/head.blade.php'),
            resource_path('views/layouts/app.blade.php'),
            resource_path('views/admin/layouts/admin.blade.php'),
        ];

        foreach ($layouts as $layout) {
            $this->assertStringContainsString(
                "@include('shared.favicon')",
                file_get_contents($layout),
                basename($layout).' must use the shared favicon partial.'
            );
        }

        $favicon = file_get_contents(resource_path('views/shared/favicon.blade.php'));

        $this->assertStringContainsString("asset('images/logo_pemprov_kalbar.webp')", $favicon);
        $this->assertSame(
            hash_file('sha256', public_path('images/logo_pemprov_kalbar.webp')),
            hash_file('sha256', public_path('frontend/img/logo_pemprov_kalbar.webp')),
            'The shared favicon and public navbar logo must remain the same emblem.'
        );
    }
}
