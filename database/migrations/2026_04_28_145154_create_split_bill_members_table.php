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
        Schema::create('split_bill_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('split_bill_id')->constrained()->onDelete('cascade');
            $table->string('member_name');
            $table->decimal('share_amount', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('split_bill_members');
    }
};
