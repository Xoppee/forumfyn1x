<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('path');
            $table->string('alt_text')->nullable();
            $table->uuid('imageable_id');
            $table->string('imageable_type');
            $table->timestamps();

            $table->index('imageable_id');
            $table->index('imageable_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};