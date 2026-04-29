<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_banned')->default(false)->after('cover');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('is_hidden')->default(false)->after('moderation_reason');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('icon');
            $table->json('permissions')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_banned');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('is_hidden');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'permissions']);
        });
    }
};