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
        Schema::table('facebook_pages', function (Blueprint $table) {
            $table->string('category')->nullable()->after('profile_picture');
            $table->unsignedBigInteger('likes')->default(0)->after('category');
            $table->unsignedBigInteger('followers')->default(0)->after('likes');
            $table->unsignedInteger('posts_count')->default(0)->after('followers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facebook_pages', function (Blueprint $table) {
            $table->dropColumn(['category', 'likes', 'followers', 'posts_count']);
        });
    }
};
