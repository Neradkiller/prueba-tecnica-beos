<?php

declare(strict_types=1);

namespace App\Domains\Product\DataTransferObjects;

use Illuminate\Http\Request;

readonly class ProductSearchData
{
    public function __construct(
        public ?string $search = null,
        public int $per_page = 15
    ) {}

    public static function fromRequest(Request $request): self
    {
        $perPage = (int) $request->input('per_page', 15);
        
        return new self(
            search: $request->input('search'),
            per_page: ($perPage > 100) ? 100 : $perPage,
        );
    }
}