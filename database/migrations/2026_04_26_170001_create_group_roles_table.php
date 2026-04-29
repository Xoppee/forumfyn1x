<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('group_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->string('color')->default('#6b7280');
            $table->integer('level')->default(0);
            $table->boolean('can_manage')->default(false);
            $table->boolean('can_kick')->default(false);
            $table->boolean('can_edit')->default(false);
            $table->boolean('can_delete')->default(false);
            $table->boolean('can_moderate')->default(false);
            $table->timestamps();

            $table->unique(['group_id', 'slug']);
            $table->index('group_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_roles');
    }
};