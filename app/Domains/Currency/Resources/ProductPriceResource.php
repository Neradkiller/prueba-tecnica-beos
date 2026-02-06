<?php

namespace App\Domains\Currency\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductPriceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'product_id'  => $this->product_id,
            'currency_id' => $this->currency_id,
            'price'       => (float) $this->price,
            'currency'    => $this->whenLoaded('currency', fn() => $this->currency->symbol),
        ];
    }
}