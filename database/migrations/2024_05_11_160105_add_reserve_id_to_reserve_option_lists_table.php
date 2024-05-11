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
        Schema::table('reserve_option_lists', function (Blueprint $table) {
            $table->foreignId('reserve_id')->constrained()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reserve_option_lists', function (Blueprint $table) {
            $table->dropColumn('reserve_id');
        });
    }
};