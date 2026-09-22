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
        Schema::create('reduksi_emisi_proklims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_proklim_id')->nullable();
            $table->foreign('data_proklim_id')->references('id')->on('data_proklims')->onDelete('cascade');
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
        Schema::dropIfExists('reduksi_emisi_proklims');
    }
};
