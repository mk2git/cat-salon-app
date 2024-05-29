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
            $table->foreignId('reserve_id')->constrained()->after('reserve_option_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reserve_option_lists', function (Blueprint $table) {
            $table->dropForeign(['reserve_id']);  // 外部キー制約を削除
            $table->dropColumn('reserve_id');     // その後カラムを削除
        });
    }
};
