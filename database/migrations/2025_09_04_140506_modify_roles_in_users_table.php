<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Temporarily change to string to allow any value
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->change();
        });

        // Now update the values
        DB::table('users')->where('role', 'guest')->update(['role' => 'waiter']);

        // Change back to ENUM with the new values
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'chef', 'waiter', 'cashier'])->default('waiter')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Temporarily change to string
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->change();
        });

        // Update values back to 'guest'
        DB::table('users')->whereIn('role', ['chef', 'waiter', 'cashier'])->update(['role' => 'guest']);

        // Change back to the old ENUM definition
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'guest'])->default('guest')->change();
        });
    }
};
