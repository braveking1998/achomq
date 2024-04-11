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
        Schema::table('multi_game_types', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Level::class, 'required_level')->after('name')->constrained('levels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('multi_game_types', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(\App\Models\Level::class);
        });
    }
};
