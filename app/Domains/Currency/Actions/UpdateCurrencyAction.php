<?php

declare(strict_types=1);

namespace App\Domains\Currency\Actions;

use App\Domains\Currency\Models\Currency;
use App\Domains\Currency\DataTransferObjects\CurrencyData;

class UpdateCurrencyAction
{
    public function execute(Currency $currency, CurrencyData $data): Currency
    {
        $currency->update([
            'name'          => $data->name,
            'symbol'        => $data->symbol,
            'exchange_rate' => $data->exchange_rate,
        ]);

        return $currency->refresh();
    }
}