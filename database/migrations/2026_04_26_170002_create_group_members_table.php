<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('group_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('group_role_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('status', ['pending', 'approved', 'banned'])->default('pending');
            $table->timestamps();

            $table->unique(['group_id', 'user_id']);
            $table->index('user_id');
            $table->index('group_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_members');
    }
};