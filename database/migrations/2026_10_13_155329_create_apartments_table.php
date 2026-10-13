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
        Schema::create('apartments', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('image')->nullable();
    $table->integer('max_persons');
    $table->string('size')->nullable();
    $table->string('view')->nullable();
    $table->integer('num_beds');
    $table->decimal('price', 10, 2);
    $table->unsignedBigInteger('hotel_id')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
