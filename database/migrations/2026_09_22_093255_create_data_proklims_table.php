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
        Schema::create('data_proklims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('kabupaten_kota_id')->nullable();
            $table->foreign('kabupaten_kota_id')->references('id')->on('regencies')->onDelete('cascade');
            $table->foreignId('kecamatan_id')->nullable();
            $table->foreign('kecamatan_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreignId('kelurahan_id')->nullable();
            $table->foreign('kelurahan_id')->references('id')->on('villages')->onDelete('cascade');
            $table->foreignId('kategori_proklim_id')->nullable();
            $table->foreign('kategori_proklim_id')->references('id')->on('md_kategori_proklims')->onDelete('cascade');
            $table->string('nama')->nullable();
            $table->longText('deskripsi')->nullable();
            $table->longText('alamat')->nullable();
            $table->string('lng')->nullable();
            $table->string('lat')->nullable();
            $table->date('tanggal_aktif')->nullable();
            $table->enum('status_aktif', ['1', '0']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_proklims');
    }
};
