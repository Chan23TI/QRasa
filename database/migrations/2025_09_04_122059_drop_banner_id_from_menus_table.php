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
        Schema::table('menus', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['banner_id']);
            // Then drop the column
            $table->dropColumn('banner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->unsignedBigInteger('banner_id')->nullable()->after('id'); // Adjust position as needed
            $table->foreign('banner_id')->references('id')->on('banners')->onDelete('cascade');
        });
    }
};