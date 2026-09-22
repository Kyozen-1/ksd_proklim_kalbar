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
        Schema::create('data_timbulan_lb3s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kabupaten_kota_id')->nullable();
            $table->foreign('kabupaten_kota_id')->references('id')->on('regencies')->onDelete('cascade');
            $table->foreignId('sektor_lb3_id')->nullable();
            $table->foreign('sektor_lb3_id')->references('id')->on('md_sektor_lb3s')->onDelete('cascade');
            $table->decimal('nilai', 20, 6)->nullable();
            $table->unsignedSmallInteger('tahun')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_timbulan_lb3s');
    }
};
