<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('data_timbulan_lb3s', function (Blueprint $table) {
            $table->index('tahun');
        });
        Schema::table('data_kualitas_lingkungans', function (Blueprint $table) {
            $table->index('tahun');
        });
        Schema::table('data_sampahs', function (Blueprint $table) {
            $table->index('tahun');
        });
        Schema::table('jumlah_penduduks', function (Blueprint $table) {
            $table->index('tahun');
        });
        Schema::table('data_emisis', function (Blueprint $table) {
            $table->index('tahun');
        });
        Schema::table('target_penurunan_emisis', function (Blueprint $table) {
            $table->index('tahun');
        });
        Schema::table('serapan_karbon_proklims', function (Blueprint $table) {
            $table->index('tahun');
        });
        Schema::table('reduksi_emisi_proklims', function (Blueprint $table) {
            $table->index('tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
