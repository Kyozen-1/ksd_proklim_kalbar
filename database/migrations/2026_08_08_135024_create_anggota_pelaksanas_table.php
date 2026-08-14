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
        Schema::create('anggota_pelaksanas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jabatan_id')->nullable();
            $table->foreign('jabatan_id')->references('id')->on('master_jabatans')->onDelete('cascade');
            $table->string('nama')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status_aktif', ['1', '0']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_pelaksanas');
    }
};
