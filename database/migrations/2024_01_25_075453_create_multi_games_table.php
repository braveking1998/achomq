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
        Schema::create('multi_games', function (Blueprint $table) {
            $table->id();
            $table->integer('stage');
            $table->foreignIdFor('\App\Models\User', 'starter')->constrained('users');
            $table->foreignIdFor('\App\Models\User', 'rival')->constrained('users')->nullable();
            $table->text('questions')->nullable();
            $table->text('s_answers')->nullable();
            $table->text('r_answers')->nullable();
            $table->integer('prev_selector');
            $table->foreignIdFor('\App\Models\Category')->constrained('categories')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multi_games');
    }
};
