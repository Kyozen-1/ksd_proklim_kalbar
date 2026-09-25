<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_kualitas_lingkungans', function (Blueprint $table) {
            $table->index(
                ['kabupaten_kota_id', 'tahun', 'kategori_kualitas_lingkungan_id'],
                'quality_region_year_category_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::table('data_kualitas_lingkungans', function (Blueprint $table) {
            $table->dropIndex('quality_region_year_category_idx');
        });
    }
};
