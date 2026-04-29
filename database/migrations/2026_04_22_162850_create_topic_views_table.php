<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topic_views', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();
            $table->uuid('topic_id');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
            $table->index('user_id');
            $table->index('topic_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topic_views');
    }
};