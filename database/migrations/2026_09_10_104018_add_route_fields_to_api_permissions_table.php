<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('api_permissions', function (Blueprint $table) {
            $table->string('slug', 150)
                ->nullable()
                ->after('name');

            $table->string('route_name', 200)
                ->nullable()
                ->after('slug');

            $table->string('method', 10)
                ->nullable()
                ->after('route_name');

            $table->boolean('is_active')
                ->default(true)
                ->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('api_permissions', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'route_name',
                'method',
                'is_active',
            ]);
        });
    }
};
