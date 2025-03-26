<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('facebook_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_id')->unique();
            $table->string('name');
            $table->string('username')->nullable();
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('access_token')->nullable();
            $table->unsignedBigInteger('likes')->default(0);
            $table->unsignedBigInteger('followers')->default(0);
            $table->unsignedInteger('posts_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facebook_pages');
    }
};
