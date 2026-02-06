<?php

declare(strict_types=1);

namespace App\Domains\Product\Actions;

use App\Domains\Product\Models\Product;

class DeleteProductAction
{
    public function execute(Product $product): void
    {
        $product->delete();
    }
}