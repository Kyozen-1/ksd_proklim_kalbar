<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_timbulan_lb3s', function (Blueprint $table) {
            $table->index(
                ['kabupaten_kota_id', 'tahun', 'sektor_lb3_id'],
                'lb3_region_year_sector_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::table('data_timbulan_lb3s', function (Blueprint $table) {
            $table->dropIndex('lb3_region_year_sector_idx');
        });
    }
};
