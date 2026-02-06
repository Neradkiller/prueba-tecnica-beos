<?php

declare(strict_types=1);

namespace App\Domains\Product\Actions;

use App\Domains\Product\Models\Product;
use App\Domains\Product\DataTransferObjects\ProductData;

class CreateProductAction
{
    /**
     * @param ProductData $data
     * @return Product
     */
    public function execute(ProductData $data): Product
    {
        
        return Product::create([
            'name'               => $data->name,
            'description'        => $data->description,
            'price'              => $data->price,
            'currency_id'        => $data->currency_id,
            'tax_cost'           => $data->tax_cost,
            'manufacturing_cost' => $data->manufacturing_cost,
        ]);
    }
}