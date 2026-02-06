<?php

declare(strict_types=1);

namespace App\Domains\Currency\Actions;

use App\Domains\Currency\Models\Currency;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetCurrencyAction
{
    public function execute(int $id): Currency
    {
        return Currency::findOrFail($id);
    }
}