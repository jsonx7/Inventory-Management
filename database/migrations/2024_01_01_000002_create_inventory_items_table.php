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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('sku', 100)->unique()->nullable(); // Stock Keeping Unit
            $table->text('description')->nullable();
            $table->foreignId('measurement_unit_id')
                  ->constrained('measurement_units')
                  ->onDelete('restrict'); // Prevent deletion if items exist
            $table->decimal('current_quantity', 15, 4)->default(0); // Support decimal quantities
            $table->decimal('minimum_quantity', 15, 4)->nullable(); // For low stock alerts
            $table->decimal('unit_price', 12, 2)->nullable(); // Price per unit
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index('name');
            $table->index('sku');
            $table->index('is_active');
            $table->index('measurement_unit_id');
            $table->index('created_at');
            
            // Full-text search index for name (MySQL specific)
            // $table->fullText('name'); // Uncomment if using MySQL 5.6+
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
