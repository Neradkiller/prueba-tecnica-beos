<?php

declare(strict_types=1);

namespace App\Domains\Currency\Actions;

use App\Domains\Currency\Models\Currency;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class DeleteCurrencyAction
{
    public function execute(Currency $currency): void
    {
        if ($currency->productPrices()->exists()) {
            throw new ConflictHttpException(
                "No se puede eliminar la divisa '{$currency->symbol}' porque tiene precios asociados a productos."
            );
        }
        $currency->delete();
    }
}