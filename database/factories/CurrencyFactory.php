<?php

namespace Database\Factories;

use App\Domains\Currency\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->currencyCode,
            'symbol' => '$', 
            'exchange_rate' => 1,
        ];
    }
}