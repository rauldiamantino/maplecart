<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'name',
        'slug',
        'description',
        'sku',
        'type',
        'status',
        'price',
        'quantity'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'type' => 'string',
        'status' => 'string',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function isSimple(): bool
    {
        return $this->type === 'simple';
    }

    public function isVariable(): bool
    {
        return $this->type === 'variable';
    }
}
