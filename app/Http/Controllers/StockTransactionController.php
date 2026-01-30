<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Http\Requests\StockTransactionRequest;
use App\Services\InventoryService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Exception;

class StockTransactionController extends Controller
{
    public function __construct(
        protected InventoryService $inventoryService
    ) {}

    /**
     * Show the form for adding stock.
     */
    public function createAddition(): Response
    {
        $items = InventoryItem::with('measurementUnit')
            ->active()
            ->orderBy('name')
            ->get();

        return Inertia::render('Stock/AddStock', [
            'items' => $items,
        ]);
    }

    /**
     * Process stock addition.
     */
    public function storeAddition(StockTransactionRequest $request): RedirectResponse
    {
        try {
            $results = $this->inventoryService->addStock($request->validated()['items']);
            
            $itemCount = count($results);
            $message = $itemCount === 1 
                ? "Stock added successfully for 1 item."
                : "Stock added successfully for {$itemCount} items.";

            return redirect()->route('inventory.index')
                ->with('success', $message);
                
        } catch (Exception $e) {
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Show the form for deducting stock.
     */
    public function createDeduction(): Response
    {
        $items = InventoryItem::with('measurementUnit')
            ->active()
            ->where('current_quantity', '>', 0)
            ->orderBy('name')
            ->get();

        return Inertia::render('Stock/DeductStock', [
            'items' => $items,
        ]);
    }

    /**
     * Process stock deduction.
     */
    public function storeDeduction(StockTransactionRequest $request): RedirectResponse
    {
        try {
            $results = $this->inventoryService->deductStock($request->validated()['items']);
            
            $itemCount = count($results);
            $message = $itemCount === 1 
                ? "Stock deducted successfully for 1 item."
                : "Stock deducted successfully for {$itemCount} items.";

            return redirect()->route('inventory.index')
                ->with('success', $message);
                
        } catch (Exception $e) {
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }
}
