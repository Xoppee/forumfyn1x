<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archives', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('file_path');
            $table->string('file_name');
            $table->string('extension');
            $table->bigInteger('size');
            $table->uuid('archivable_id');
            $table->string('archivable_type');
            $table->timestamps();

            $table->index('archivable_id');
            $table->index('archivable_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};