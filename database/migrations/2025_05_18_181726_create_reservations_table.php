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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->enum('status', ['pending', 'booked', 'cancelled', 'no_show', 'checked_in', 'checked_out', 'completed'])
                ->default('pending');
            $table->integer('number_of_guests');
            $table->string('special_requests')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->string('cancellation_date')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->decimal('discount_rate', 5, 2)->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded', 'unpaid'])->default('pending');
            $table->enum('payment_method', ['cash', 'credit_card', 'online', 'none'])->nullable();
            $table->string('confirmation_number')->unique();
            $table->text('note')->nullable();
            $table->boolean('auto_cancelled')->default(false);
            $table->boolean('no_show_billed')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
