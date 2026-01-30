<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class InventoryItem extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'sku',
        'description',
        'measurement_unit_id',
        'current_quantity',
        'minimum_quantity',
        'unit_price',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'current_quantity' => 'decimal:4',
        'minimum_quantity' => 'decimal:4',
        'unit_price' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['is_low_stock'];

    /**
     * Get the measurement unit that owns the inventory item.
     */
    public function measurementUnit(): BelongsTo
    {
        return $this->belongsTo(MeasurementUnit::class);
    }

    /**
     * Get the transactions for the inventory item.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    /**
     * Check if the item is low on stock.
     */
    public function getIsLowStockAttribute(): bool
    {
        if ($this->minimum_quantity === null) {
            return false;
        }

        return $this->current_quantity <= $this->minimum_quantity;
    }

    /**
     * Scope a query to only include active items.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include low stock items.
     */
    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereNotNull('minimum_quantity')
                     ->whereColumn('current_quantity', '<=', 'minimum_quantity');
    }

    /**
     * Scope a query to search by name or SKU.
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('sku', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Get the total value of this item in inventory.
     */
    public function getTotalValueAttribute(): ?float
    {
        if ($this->unit_price === null) {
            return null;
        }

        return (float) $this->current_quantity * (float) $this->unit_price;
    }
}
