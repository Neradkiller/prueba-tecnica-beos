<?php

use App\Domains\Currency\Models\Currency;
use App\Domains\Product\Models\Product;
use App\Domains\Currency\Models\ProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('puede crear una nueva divisa', function () {
    $this->postJson('/api/currencies', [
        'name' => 'Euro',
        'symbol' => '€',
        'exchange_rate' => 0.85
    ])->assertStatus(201);

    $this->assertDatabaseHas('currencies', ['symbol' => '€']);
});

test('puede eliminar una divisa sin uso', function () {
    $currency = Currency::create(['name' => 'Yen', 'symbol' => '¥', 'exchange_rate' => 110]);

    $this->deleteJson("/api/currencies/{$currency->id}")
         ->assertStatus(200);
         
    $this->assertSoftDeleted('currencies', ['id' => $currency->id]);
});

test('NO puede eliminar una divisa si tiene precios asociados', function () {
    $usd = Currency::create(['name' => 'USD', 'symbol' => '$', 'exchange_rate' => 1]);
    $euro = Currency::create(['name' => 'Euro', 'symbol' => '€', 'exchange_rate' => 0.85]);

    $product = Product::create([
        'name' => 'Test', 'description' => '.', 'price' => 10, 
        'currency_id' => $usd->id, 'tax_cost' => 1, 'manufacturing_cost' => 1
    ]);

    ProductPrice::create([
        'product_id' => $product->id,
        'currency_id' => $euro->id,
        'price' => 8.5
    ]);

    $this->deleteJson("/api/currencies/{$euro->id}")
         ->assertStatus(409) 
         ->assertJson(['message' => "No se puede eliminar la divisa '€' porque tiene precios asociados a productos."]);

    $this->assertDatabaseHas('currencies', ['id' => $euro->id]);
});