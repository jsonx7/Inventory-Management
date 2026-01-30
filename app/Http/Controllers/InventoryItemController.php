<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\MeasurementUnit;
use App\Http\Requests\StoreInventoryItemRequest;
use App\Http\Requests\UpdateInventoryItemRequest;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class InventoryItemController extends Controller
{
    public function __construct(
        protected InventoryService $inventoryService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $search = $request->input('search');
        
        $items = InventoryItem::with('measurementUnit')
            ->search($search)
            ->active()
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Inventory/Index', [
            'items' => $items,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $measurementUnits = MeasurementUnit::active()
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return Inertia::render('Inventory/Create', [
            'measurementUnits' => $measurementUnits,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInventoryItemRequest $request): RedirectResponse
    {
        $item = InventoryItem::create($request->validated());

        return redirect()->route('inventory.index')
            ->with('success', "Item '{$item->name}' created successfully.");
    }

    /**
     * Display the specified resource.
     */
    public function show($id): Response
    {
        $item = InventoryItem::findOrFail($id);
        $item->load('measurementUnit');
        
        $transactions = $this->inventoryService->getItemHistory($item->id, 20);

        return Inertia::render('Inventory/Show', [
            'item' => $item,
            'transactions' => $transactions,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): Response
    {
        $item = InventoryItem::findOrFail($id);
        $measurementUnits = MeasurementUnit::active()
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return Inertia::render('Inventory/Edit', [
            'item' => $item,
            'measurementUnits' => $measurementUnits,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventoryItemRequest $request, $id): RedirectResponse
    {
        $item = InventoryItem::findOrFail($id);
        $item->update($request->validated());

        return redirect()->route('inventory.show', $item->id)
            ->with('success', "Item '{$item->name}' updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $item = InventoryItem::findOrFail($id);
        $name = $item->name;
        $item->delete();

        return redirect()->route('inventory.index')
            ->with('success', "Item '{$name}' deleted successfully.");
    }
}
