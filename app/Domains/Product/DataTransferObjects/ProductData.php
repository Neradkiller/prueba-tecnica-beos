<?php

namespace App\Domains\Product\DataTransferObjects;

use App\Domains\Product\Requests\StoreProductRequest;

readonly class ProductData
{
    public function __construct(
        public string $name,
        public string $description,
        public float $price,
        public int $currency_id,
        public float $tax_cost,
        public float $manufacturing_cost,
    ) {}

    public static function fromRequest(StoreProductRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            description: $request->validated('description'),
            price: (float) $request->validated('price'),
            currency_id: (int) $request->validated('currency_id'),
            tax_cost: (float) $request->validated('tax_cost'),
            manufacturing_cost: (float) $request->validated('manufacturing_cost'),
        );
    }
}