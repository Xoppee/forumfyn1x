<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('images', function (Blueprint $table) {
            if (!Schema::hasColumn('images', 'mime_type')) {
                $table->string('mime_type')->nullable()->after('alt_text');
            }
            if (!Schema::hasColumn('images', 'size')) {
                $table->integer('size')->nullable()->after('mime_type');
            }
            if (!Schema::hasColumn('images', 'user_id')) {
                $table->uuid('user_id')->nullable()->after('imageable_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn(['mime_type', 'size', 'user_id']);
        });
    }
};
