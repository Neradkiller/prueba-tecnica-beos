<?php

declare(strict_types=1);

namespace App\Domains\Currency\Actions;

use App\Domains\Currency\Models\Currency;
use App\Domains\Currency\DataTransferObjects\CurrencySearchData;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class GetAllCurrenciesAction
{
    public function execute(CurrencySearchData $filters): LengthAwarePaginator
    {
        return Currency::query()
            ->when($filters->search, function (Builder $query) use ($filters) {
                $query->where(function (Builder $subQuery) use ($filters) {
                    $subQuery->where('name', 'like', "%{$filters->search}%")
                             ->orWhere('symbol', 'like', "%{$filters->search}%");
                });
            })
            ->orderBy('id')
            ->paginate($filters->per_page);
    }
}