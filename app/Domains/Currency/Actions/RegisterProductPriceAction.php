<?php

declare(strict_types=1);

namespace App\Domains\Currency\Actions;

use App\Domains\Currency\Models\ProductPrice;
use App\Domains\Currency\DataTransferObjects\ProductPriceData;

class RegisterProductPriceAction
{
    public function execute(ProductPriceData $data): ProductPrice
    {
        return ProductPrice::create([
            'product_id'  => $data->product_id,
            'currency_id' => $data->currency_id,
            'price'       => $data->price,
        ]);
    }
}