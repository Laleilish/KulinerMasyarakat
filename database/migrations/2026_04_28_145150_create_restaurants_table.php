<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('image');
            $table->text('description')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->decimal('rating', 2, 1)->default(4.5);
            $table->string('distance')->default('0.5km');
            $table->string('price_range')->default('Rp 10.000 – 30.000');
            $table->string('category');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('restaurants');
    }
};