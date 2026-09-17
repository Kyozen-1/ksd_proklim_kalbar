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
        Schema::create('api_client_permissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('api_client_id')
                ->constrained('api_clients')
                ->cascadeOnDelete();

            $table->foreignId('api_permission_id')
                ->constrained('api_permissions')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'api_client_id',
                'api_permission_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_client_permissions');
    }
};
