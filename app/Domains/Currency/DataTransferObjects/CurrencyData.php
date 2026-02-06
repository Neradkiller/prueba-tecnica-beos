<?php

declare(strict_types=1);

namespace App\Domains\Currency\DataTransferObjects;

use App\Domains\Currency\Requests\StoreCurrencyRequest;

readonly class CurrencyData
{
    public function __construct(
        public string $name,
        public string $symbol,
        public float $exchange_rate,
    ) {}

    public static function fromRequest(StoreCurrencyRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            symbol: $request->validated('symbol'),
            exchange_rate: (float) $request->validated('exchange_rate'),
        );
    }
}