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
        Schema::table('multi_games', function (Blueprint $table) {
            $table->boolean('is_playing')->default(0)->after('r_answers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('multi_games', function (Blueprint $table) {
            $table->dropColumn('is_playing');
        });
    }
};
