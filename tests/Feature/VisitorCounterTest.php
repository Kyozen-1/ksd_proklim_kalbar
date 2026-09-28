<?php

namespace Tests\Feature;

use App\Models\WebsiteVisitStat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitorCounterTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_counts_one_visit_per_browser_session(): void
    {
        $this->get('/')->assertOk();
        $this->get('/')->assertOk();

        $this->assertDatabaseCount('website_visit_stats', 1);
        $this->assertDatabaseHas('website_visit_stats', [
            'visit_date' => now()->toDateString(),
            'visits' => 1,
        ]);

        $this->flushSession();
        $response = $this->get('/');

        $response->assertOk();
        $this->assertSame(2, WebsiteVisitStat::query()->sum('visits'));
        $response->assertSee('2 kunjungan');
    }
}
