<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->longText('body');
            $table->uuid('user_id');
            $table->uuid('topic_id');
            $table->string('moderation_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
            $table->index('user_id');
            $table->index('topic_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};