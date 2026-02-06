<?php

declare(strict_types=1);

namespace App\Domains\Product\Actions;

use App\Domains\Product\Models\Product;
use App\Domains\Product\DataTransferObjects\ProductData;

class UpdateProductAction
{
    public function execute(Product $product, ProductData $data): Product
    {
        $product->update([
            'name'               => $data->name,
            'description'        => $data->description,
            'price'              => $data->price,
            'currency_id'        => $data->currency_id,
            'tax_cost'           => $data->tax_cost,
            'manufacturing_cost' => $data->manufacturing_cost,
        ]);

        return $product->refresh();
    }
}