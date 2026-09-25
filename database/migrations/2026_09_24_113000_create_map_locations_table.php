<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('map_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('regency_id')->nullable()->constrained('regencies')->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('feature', 40);
            $table->string('title');
            $table->string('category')->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->string('metric_label')->nullable();
            $table->decimal('metric_value', 20, 4)->nullable();
            $table->string('metric_unit', 40)->nullable();
            $table->string('additional_info')->nullable();
            $table->string('source_url')->nullable();
            $table->string('image_url')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();

            $table->index(['status_aktif', 'feature', 'regency_id'], 'map_feature_region_active_idx');
            $table->index(['latitude', 'longitude'], 'map_coordinate_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('map_locations');
    }
};
