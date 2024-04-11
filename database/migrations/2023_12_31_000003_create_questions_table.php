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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->uuid('unique_id')->unique();
            $table->foreignIdFor(\App\Models\User::class)->constrained('users');
            $table->string('text');
            $table->foreignIdFor(\App\Models\Level::class)->constrained('levels');
            $table->foreignIdFor(\App\Models\Category::class)->constrained('categories')->cascadeOnUpdate();
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
