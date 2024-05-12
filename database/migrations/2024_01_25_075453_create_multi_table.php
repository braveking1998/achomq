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
        Schema::create('multi', function (Blueprint $table) {
            $table->id();
            $table->integer('stage');
            $table->foreignIdFor('\App\Models\MultiType')->nullable()->constrained('multi_types');
            $table->foreignIdFor('\App\Models\User', 'starter')->constrained('users');
            $table->foreignIdFor('\App\Models\User', 'rival')->constrained('users')->nullable();
            $table->text('questions')->nullable();
            $table->text('s_answers')->nullable();
            $table->text('r_answers')->nullable();
            $table->integer('prev_selector');
            $table->foreignIdFor('\App\Models\Category')->constrained('categories')->nullable();
            $table->integer('s_corrects')->default(0);
            $table->integer('r_corrects')->default(0);
            $table->boolean('is_playing')->default(0);
            $table->integer('who_to_play');
            $table->boolean('is_active')->default(1);
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
