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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->char('car_title');
            $table->integer('distance_limit', false, true)
                ->nullable()->comment('in Kilo Meters');
            $table->smallInteger('fees_for_extra_KM', false, true)->nullable();
            $table->smallInteger('year', false, true);
            $table->char('car_color', '50');
            $table->smallInteger('price_per_day');
            $table->json('car_images');
            $table->boolean('is_available')->default(1);
            $table->foreignId('branch_id')->constrained('branches')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('model_id')->constrained('models')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('brand_id')->constrained('brands')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('created_by')->constrained('users')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
