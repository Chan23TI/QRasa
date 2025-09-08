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
        Schema::table('pesans', function (Blueprint $table) {
            $table->dropForeign(['banner_id']);
            $table->dropColumn('banner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesans', function (Blueprint $table) {
            $table->unsignedBigInteger('banner_id')->nullable()->after('meja_id');
            $table->foreign('banner_id')->references('id')->on('banners')->onDelete('set null');
        });
    }
};