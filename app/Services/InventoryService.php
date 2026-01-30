<?php

namespace App\Services;

use App\Models\InventoryItem;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class InventoryService
{
    /**
     * Add stock to inventory items.
     *
     * @param array $items Array of items with ['item_id' => int, 'quantity' => float, 'notes' => string|null, 'reference_number' => string|null]
     * @return array
     * @throws Exception
     */
    public function addStock(array $items): array
    {
        return DB::transaction(function () use ($items) {
            $results = [];
            $userId = Auth::id();

            foreach ($items as $itemData) {
                $item = InventoryItem::findOrFail($itemData['item_id']);
                
                if (!$item->is_active) {
                    throw new Exception("Item '{$item->name}' is not active.");
                }

                $quantity = (float) $itemData['quantity'];
                
                if ($quantity <= 0) {
                    throw new Exception("Quantity must be greater than zero.");
                }

                $quantityBefore = $item->current_quantity;
                $quantityAfter = $quantityBefore + $quantity;

                // Create transaction record
                $transaction = InventoryTransaction::create([
                    'inventory_item_id' => $item->id,
                    'type' => InventoryTransaction::TYPE_ADDITION,
                    'quantity' => $quantity,
                    'quantity_before' => $quantityBefore,
                    'quantity_after' => $quantityAfter,
                    'reference_number' => $itemData['reference_number'] ?? null,
                    'notes' => $itemData['notes'] ?? null,
                    'user_id' => $userId,
                    'transaction_date' => now(),
                ]);

                // Update item quantity
                $item->current_quantity = $quantityAfter;
                $item->save();

                $results[] = [
                    'item' => $item->fresh(['measurementUnit']),
                    'transaction' => $transaction,
                ];
            }

            return $results;
        });
    }

    /**
     * Deduct stock from inventory items.
     *
     * @param array $items Array of items with ['item_id' => int, 'quantity' => float, 'notes' => string|null, 'reference_number' => string|null]
     * @return array
     * @throws Exception
     */
    public function deductStock(array $items): array
    {
        return DB::transaction(function () use ($items) {
            $results = [];
            $userId = Auth::id();

            // First, validate all items before making any changes
            foreach ($items as $itemData) {
                $item = InventoryItem::findOrFail($itemData['item_id']);
                
                if (!$item->is_active) {
                    throw new Exception("Item '{$item->name}' is not active.");
                }

                $quantity = (float) $itemData['quantity'];
                
                if ($quantity <= 0) {
                    throw new Exception("Quantity must be greater than zero.");
                }

                if ($item->current_quantity < $quantity) {
                    throw new Exception(
                        "Insufficient stock for '{$item->name}'. Available: {$item->current_quantity}, Requested: {$quantity}"
                    );
                }
            }

            // If all validations pass, process the deductions
            foreach ($items as $itemData) {
                $item = InventoryItem::findOrFail($itemData['item_id']);
                $quantity = (float) $itemData['quantity'];
                
                $quantityBefore = $item->current_quantity;
                $quantityAfter = $quantityBefore - $quantity;

                // Create transaction record
                $transaction = InventoryTransaction::create([
                    'inventory_item_id' => $item->id,
                    'type' => InventoryTransaction::TYPE_DEDUCTION,
                    'quantity' => $quantity,
                    'quantity_before' => $quantityBefore,
                    'quantity_after' => $quantityAfter,
                    'reference_number' => $itemData['reference_number'] ?? null,
                    'notes' => $itemData['notes'] ?? null,
                    'user_id' => $userId,
                    'transaction_date' => now(),
                ]);

                // Update item quantity
                $item->current_quantity = $quantityAfter;
                $item->save();

                $results[] = [
                    'item' => $item->fresh(['measurementUnit']),
                    'transaction' => $transaction,
                ];
            }

            return $results;
        });
    }

    /**
     * Get transaction history for a specific item.
     *
     * @param int $itemId
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getItemHistory(int $itemId, int $perPage = 20)
    {
        return InventoryTransaction::with(['user:id,name'])
            ->forItem($itemId)
            ->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    /**
     * Search inventory items.
     *
     * @param string|null $search
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function searchItems(?string $search, int $perPage = 20)
    {
        return InventoryItem::with('measurementUnit')
            ->search($search)
            ->active()
            ->orderBy('name')
            ->paginate($perPage);
    }
}
