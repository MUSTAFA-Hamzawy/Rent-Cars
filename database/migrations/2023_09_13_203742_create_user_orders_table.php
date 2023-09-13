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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_cost', false, true);
            $table->enum('order_status', ['0', '1', '-1'])
                ->comment('0: Pending || 1: Confirmed || -1: Cancelled')
                ->default('0');
            $table->foreignId('user_id')->constrained('users')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('car_id')->constrained('cars')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('branch_id')->comment('For the pickup location')
                ->constrained('branches')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('payment_method_id')->constrained('payment_methods')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_orders');
    }
};
