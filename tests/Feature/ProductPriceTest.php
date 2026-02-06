<?php

use App\Domains\Currency\Models\Currency;
use App\Domains\Product\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->usd = Currency::create(['name' => 'USD', 'symbol' => '$', 'exchange_rate' => 1]);
    $this->product = Product::create([
        'name' => 'Café', 'description' => 'Negro', 'price' => 5, 
        'currency_id' => $this->usd->id, 'tax_cost' => 0, 'manufacturing_cost' => 1
    ]);
});

test('puede agregar un precio en otra moneda a un producto', function () {
    $euro = Currency::create(['name' => 'Euro', 'symbol' => '€', 'exchange_rate' => 0.85]);

    $this->postJson("/api/products/{$this->product->id}/prices", [
        'currency_id' => $euro->id,
        'price' => 4.25
    ])->assertStatus(201);

    $this->assertDatabaseHas('product_prices', [
        'product_id' => $this->product->id,
        'currency_id' => $euro->id,
        'price' => 4.25
    ]);
});

test('puede listar los precios de un producto', function () {
    $euro = Currency::create(['name' => 'Euro', 'symbol' => '€', 'exchange_rate' => 0.85]);
    
    \App\Domains\Currency\Models\ProductPrice::create([
        'product_id' => $this->product->id,
        'currency_id' => $euro->id,
        'price' => 4.25
    ]);

    $response = $this->getJson("/api/products/{$this->product->id}/prices");

    $response->assertStatus(200)
             ->assertJsonCount(1);
});