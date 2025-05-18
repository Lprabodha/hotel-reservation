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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->onDelete('cascade');
            $table->decimal('room_charges', 10, 2);
            $table->decimal('restaurant_charges', 10, 2)->default(0);
            $table->decimal('room_service_charges', 10, 2)->default(0);
            $table->decimal('laundry_charges', 10, 2)->default(0);
            $table->decimal('telephone_charges', 10, 2)->default(0);
            $table->decimal('club_facility_charges', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
