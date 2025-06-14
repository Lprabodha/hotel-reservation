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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->string('location');
            $table->string('phone')->nullable()->index();
            $table->enum('type', ['luxury', 'boutique', 'budget', 'business', 'resort'])->default('budget')->index();
            $table->string('email')->unique()->index();
            $table->integer('star_rating')->default(0)->index();
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->text('country')->nullable();
            $table->string('website')->nullable()->index();
            $table->json('images')->nullable();
            $table->boolean('active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
