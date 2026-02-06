<?php

declare(strict_types=1);

namespace App\Domains\Product\Actions;

use App\Domains\Product\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetProductAction
{
    public function execute(int $id): Product
    {
        return Product::findOrFail($id);
    }
}