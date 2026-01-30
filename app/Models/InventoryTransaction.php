<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class InventoryTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'inventory_item_id',
        'type',
        'quantity',
        'quantity_before',
        'quantity_after',
        'reference_number',
        'notes',
        'user_id',
        'transaction_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'decimal:4',
        'quantity_before' => 'decimal:4',
        'quantity_after' => 'decimal:4',
        'transaction_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Transaction types constants.
     */
    const TYPE_ADDITION = 'addition';
    const TYPE_DEDUCTION = 'deduction';

    /**
     * Get the inventory item that owns the transaction.
     */
    public function inventoryItem(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class);
    }

    /**
     * Get the user that performed the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include additions.
     */
    public function scopeAdditions(Builder $query): Builder
    {
        return $query->where('type', self::TYPE_ADDITION);
    }

    /**
     * Scope a query to only include deductions.
     */
    public function scopeDeductions(Builder $query): Builder
    {
        return $query->where('type', self::TYPE_DEDUCTION);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateRange(Builder $query, $startDate, $endDate): Builder
    {
        return $query->whereBetween('transaction_date', [$startDate, $endDate]);
    }

    /**
     * Scope a query to filter by inventory item.
     */
    public function scopeForItem(Builder $query, int $itemId): Builder
    {
        return $query->where('inventory_item_id', $itemId);
    }

    /**
     * Get formatted transaction type.
     */
    public function getFormattedTypeAttribute(): string
    {
        return ucfirst($this->type);
    }
}
