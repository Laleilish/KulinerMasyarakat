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
        Schema::table('submit_places', function (Blueprint $table) {
            $table->foreignId('campus_id')->nullable()->change();
            $table->string('food_type')->nullable()->change();
            $table->string('open_hours')->nullable()->change();
            $table->string('price_range')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submit_places', function (Blueprint $table) {
            $table->foreignId('campus_id')->nullable(false)->change();
            $table->string('food_type')->nullable(false)->change();
            $table->string('open_hours')->nullable(false)->change();
            $table->string('price_range')->nullable(false)->change();
        });
    }
};
