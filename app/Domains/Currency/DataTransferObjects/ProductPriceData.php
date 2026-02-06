<?php

declare(strict_types=1);

namespace App\Domains\Currency\DataTransferObjects;

use App\Domains\Currency\Requests\StoreProductPriceRequest;

readonly class ProductPriceData
{
    public function __construct(
        public int $product_id,
        public int $currency_id,
        public float $price,
    ) {}

    public static function fromRequest(StoreProductPriceRequest $request, int $productId): self
    {
        return new self(
            product_id: $productId,
            currency_id: (int) $request->validated('currency_id'),
            price: (float) $request->validated('price'),
        );
    }
}