<?php

declare(strict_types=1);

namespace App\Domains\Currency\Actions;

use App\Domains\Currency\Models\Currency;
use App\Domains\Currency\DataTransferObjects\CurrencyData;

class CreateCurrencyAction
{
    public function execute(CurrencyData $data): Currency
    {
        return Currency::create([
            'name'          => $data->name,
            'symbol'        => $data->symbol,
            'exchange_rate' => $data->exchange_rate,
        ]);
    }
}