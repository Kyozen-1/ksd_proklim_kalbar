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
        Schema::create('data_sampahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kabupaten_kota_id')->nullable();
            $table->foreign('kabupaten_kota_id')->references('id')->on('regencies')->onDelete('cascade');
            $table->foreignId('kategori_sampah_id')->nullable();
            $table->foreign('kategori_sampah_id')->references('id')->on('md_kategori_sampahs')->onDelete('cascade');
            $table->decimal('nilai', 20, 6)->nullable();
            $table->unsignedSmallInteger('tahun')->nullable();
            $table->decimal('sampah_terkelola', 20, 6)->nullable();
            $table->enum('status_aktif', ['1', '0']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_sampahs');
    }
};
