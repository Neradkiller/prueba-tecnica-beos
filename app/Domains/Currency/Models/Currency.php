<?php

namespace App\Domains\Currency\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Database\Factories\CurrencyFactory;

class Currency extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['name', 'symbol', 'exchange_rate']; 

    protected $casts = [
        'exchange_rate' => 'decimal:8', 
    ];

    protected static function newFactory()
    {
        return CurrencyFactory::new();
    }

    public function productPrices(): HasMany
    {
        return $this->hasMany(ProductPrice::class);
    }
}