<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_emisis', function (Blueprint $table) {
            $table->index(
                ['status_aktif', 'kabupaten_kota_id', 'tahun', 'jenis_emisi_id'],
                'igrk_public_region_year_type_idx'
            );
        });

        Schema::table('target_penurunan_emisis', function (Blueprint $table) {
            $table->index(['kabupaten_kota_id', 'tahun'], 'igrk_target_region_year_idx');
        });
    }

    public function down(): void
    {
        Schema::table('data_emisis', function (Blueprint $table) {
            $table->dropIndex('igrk_public_region_year_type_idx');
        });

        Schema::table('target_penurunan_emisis', function (Blueprint $table) {
            $table->dropIndex('igrk_target_region_year_idx');
        });
    }
};
