<?php

declare(strict_types=1);

namespace App\Domains\Product\Actions;

use App\Domains\Product\Models\Product;
use App\Domains\Product\DataTransferObjects\ProductSearchData;
use Illuminate\Contracts\Pagination\LengthAwarePaginator; 
use Illuminate\Database\Eloquent\Builder;

class GetAllProductsAction
{
    public function execute(ProductSearchData $filters): LengthAwarePaginator
    {
        return Product::query()
            ->with(['prices']) 
            ->when($filters->search, function (Builder $query) use ($filters) {
                $query->where('name', 'like', "%{$filters->search}%")
                      ->orWhere('description', 'like', "%{$filters->search}%");
            })
            ->latest('id')
            ->paginate($filters->per_page); 
    }
}