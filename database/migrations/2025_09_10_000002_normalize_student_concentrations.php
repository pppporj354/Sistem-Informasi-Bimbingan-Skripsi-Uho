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
        // Update existing student concentrations to match the enum values
        DB::table('students')->where('concentration', 'rpl')->update(['concentration' => 'RPL']);
        DB::table('students')->where('concentration', 'multimedia')->update(['concentration' => 'Multimedia']);
        DB::table('students')->where('concentration', 'tkj')->update(['concentration' => 'TKJ']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the changes back to lowercase
        DB::table('students')->where('concentration', 'RPL')->update(['concentration' => 'rpl']);
        DB::table('students')->where('concentration', 'Multimedia')->update(['concentration' => 'multimedia']);
        DB::table('students')->where('concentration', 'TKJ')->update(['concentration' => 'tkj']);
    }
};
