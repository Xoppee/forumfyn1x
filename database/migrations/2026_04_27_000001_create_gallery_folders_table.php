<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_folders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_public')->default(true);
            $table->timestamps();

            $table->unique(['slug', 'user_id']);
            $table->index('user_id');
        });

        Schema::table('images', function (Blueprint $table) {
            $table->foreignUuid('folder_id')->nullable()->constrained('gallery_folders')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropForeign(['folder_id']);
            $table->dropColumn('folder_id');
        });
        Schema::dropIfExists('gallery_folders');
    }
};