<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramActionToolbarTest extends TestCase
{
    use RefreshDatabase;

    public function test_each_dashboard_toolbar_switches_to_every_program_feature(): void
    {
        $features = [
            'proklim' => '/program-aksi/proklim',
            'igrk' => '/program-aksi/igrk',
            'sampah' => '/program-aksi/sampah',
            'kualitas-lingkungan' => '/program-aksi/kualitas-lingkungan',
            'lb3' => '/program-aksi/lb3',
        ];

        foreach ($features as $activeFeature => $path) {
            $response = $this->get("{$path}?year=2026");

            $response->assertOk()
                ->assertSee('Pilih fitur Program dan Aksi', false)
                ->assertSee(route('data'), false);

            foreach ($features as $feature => $featurePath) {
                $featureUrl = url($featurePath).'?year=2026';
                $response->assertSee($featureUrl, false);

                if ($feature === $activeFeature) {
                    $this->assertMatchesRegularExpression(
                        '/href="'.preg_quote($featureUrl, '/').'"\s+aria-current="page"/',
                        $response->getContent()
                    );
                }
            }
        }
    }
}
