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
            $table->integer('s_corrects')->default(0);
            $table->integer('r_corrects')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('multi_games', function (Blueprint $table) {
            $table->dropColumn('s_corrects');
            $table->dropColumn('r_corrects');
        });
    }
};
