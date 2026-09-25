<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_sampahs', function (Blueprint $table) {
            $table->index(
                ['status_aktif', 'kabupaten_kota_id', 'tahun', 'kategori_sampah_id'],
                'sampah_public_region_year_category_idx'
            );
        });

        Schema::table('jumlah_penduduks', function (Blueprint $table) {
            $table->index(['kabupaten_kota_id', 'tahun'], 'sampah_population_region_year_idx');
        });
    }

    public function down(): void
    {
        Schema::table('data_sampahs', function (Blueprint $table) {
            $table->dropIndex('sampah_public_region_year_category_idx');
        });

        Schema::table('jumlah_penduduks', function (Blueprint $table) {
            $table->dropIndex('sampah_population_region_year_idx');
        });
    }
};
