<?php

namespace App\Domains\Currency\Models;

use App\Domains\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Currency\Models\Currency;

class ProductPrice extends Model
{
    protected $fillable = ['product_id', 'currency_id', 'price']; 

    protected $casts = [
        'price' => 'decimal:2', 
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class)->withTrashed();
    }
}
