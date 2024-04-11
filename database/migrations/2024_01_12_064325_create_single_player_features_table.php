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
        Schema::create('single_player_features', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Level::class)->constrained('levels')->onDelete('cascade');
            $table->string('feature');
            $table->string('value');
            $table->unique(['level_id', 'feature']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('single_player_features');
    }
};
