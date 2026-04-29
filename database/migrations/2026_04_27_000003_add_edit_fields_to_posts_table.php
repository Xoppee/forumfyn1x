<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'is_edited')) {
                $table->boolean('is_edited')->default(false)->after('body');
            }
            if (!Schema::hasColumn('posts', 'old_post')) {
                $table->longText('old_post')->nullable()->after('is_edited');
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['is_edited', 'old_post']);
        });
    }
};
