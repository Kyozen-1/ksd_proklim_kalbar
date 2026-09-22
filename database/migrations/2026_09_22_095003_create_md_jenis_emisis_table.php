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
        Schema::create('md_jenis_emisis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sektor_utama_emisi_id')->nullable();
            $table->foreign('sektor_utama_emisi_id')->references('id')->on('md_sektor_utama_emisis')->onDelete('cascade');
            $table->string('nama')->nullable();
            $table->enum('jenis_perhitungan', ['tambah', 'kurang']);
            $table->enum('status_aktif', ['1', '0']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('md_jenis_emisis');
    }
};
