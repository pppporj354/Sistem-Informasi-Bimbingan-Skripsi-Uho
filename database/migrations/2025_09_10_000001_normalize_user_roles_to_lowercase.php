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
        // Normalize all existing user roles to lowercase
        DB::table('users')->update([
            'role' => DB::raw('LOWER(role)')
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration cannot be fully reversed since we don't know the original casing
        // But we can restore some common uppercase variants if needed
        DB::table('users')->where('role', 'admin')->update(['role' => 'Admin']);
        DB::table('users')->where('role', 'hod')->update(['role' => 'HoD']);
        DB::table('users')->where('role', 'lecturer')->update(['role' => 'Lecturer']);
        DB::table('users')->where('role', 'student')->update(['role' => 'Student']);
    }
};
