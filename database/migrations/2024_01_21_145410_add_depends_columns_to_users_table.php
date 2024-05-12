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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Level::class)->after("is_admin")->default(1)->constrained('levels')->onUpdate('cascade');
            $table->foreignIdFor('\App\Models\ProfileImage', 'profile_image')->after("is_admin")->default(1)->constrained('profile_images')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor('\App\Models\ProfileImage', 'profile_image');
            $table->dropConstrainedForeignIdFor(\App\Models\Level::class);
        });
    }
};
