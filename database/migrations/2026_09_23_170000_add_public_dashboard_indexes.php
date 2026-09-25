<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_proklims', function (Blueprint $table) {
            $table->index(['status_aktif', 'kabupaten_kota_id', 'tanggal_aktif'], 'proklim_public_region_year_idx');
            $table->index(['kabupaten_kota_id', 'kecamatan_id', 'kategori_proklim_id'], 'proklim_public_grouping_idx');
        });

        Schema::table('serapan_karbon_proklims', function (Blueprint $table) {
            $table->index(['data_proklim_id', 'tahun'], 'proklim_carbon_year_idx');
        });

        Schema::table('reduksi_emisi_proklims', function (Blueprint $table) {
            $table->index(['data_proklim_id', 'tahun'], 'proklim_emission_year_idx');
        });
    }

    public function down(): void
    {
        Schema::table('data_proklims', function (Blueprint $table) {
            $table->dropIndex('proklim_public_region_year_idx');
            $table->dropIndex('proklim_public_grouping_idx');
        });

        Schema::table('serapan_karbon_proklims', function (Blueprint $table) {
            $table->dropIndex('proklim_carbon_year_idx');
        });

        Schema::table('reduksi_emisi_proklims', function (Blueprint $table) {
            $table->dropIndex('proklim_emission_year_idx');
        });
    }
};
