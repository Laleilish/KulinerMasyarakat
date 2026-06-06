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
            $table->unsignedTinyInteger('initial_rating')->default(1)->after('landmark_photo');
            $table->text('initial_review')->nullable()->after('initial_rating');
            $table->json('initial_review_photos')->nullable()->after('initial_review');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submit_places', function (Blueprint $table) {
            $table->dropColumn(['initial_rating', 'initial_review', 'initial_review_photos']);
        });
    }
};
