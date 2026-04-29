<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->uuid('user_id')->nullable();
            $table->uuid('group_id')->nullable();
            $table->boolean('is_sticky')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->string('moderation_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');
            $table->index('slug');
            $table->index('user_id');
            $table->index('group_id');
            $table->index('is_sticky');
            $table->index('is_locked');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};