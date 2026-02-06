<?php

namespace Database\Factories;

use App\Domains\Product\Models\Product;
use App\Domains\Currency\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'currency_id' => Currency::factory(), 
            'tax_cost' => $this->faker->randomFloat(2, 1, 50),
            'manufacturing_cost' => $this->faker->randomFloat(2, 5, 100),
        ];
    }
}