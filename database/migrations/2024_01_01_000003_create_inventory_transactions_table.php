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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_item_id')
                  ->constrained('inventory_items')
                  ->onDelete('cascade'); // Delete transactions when item is deleted
            $table->enum('type', ['addition', 'deduction']); // Transaction type
            $table->decimal('quantity', 15, 4); // Quantity added or deducted
            $table->decimal('quantity_before', 15, 4); // Quantity before transaction
            $table->decimal('quantity_after', 15, 4); // Quantity after transaction
            $table->string('reference_number', 100)->nullable(); // PO number, invoice, etc.
            $table->text('notes')->nullable(); // Additional information
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('restrict'); // Keep transaction history even if user deleted
            $table->timestamp('transaction_date')->useCurrent();
            $table->timestamps();
            
            // Indexes for performance and reporting
            $table->index('inventory_item_id');
            $table->index('type');
            $table->index('user_id');
            $table->index('transaction_date');
            $table->index('created_at');
            $table->index(['inventory_item_id', 'transaction_date']); // Composite index for item history
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
