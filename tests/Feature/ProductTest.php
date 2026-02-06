<?php

use App\Domains\Currency\Models\Currency;
use App\Domains\Product\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->currency = Currency::create([
        'name' => 'US Dollar',
        'symbol' => 'USD',
        'exchange_rate' => 1
    ]);
});

test('listar productos devuelve paginacion correcta', function () {
    Product::factory()->count(3)->create(['currency_id' => $this->currency->id]);

    $response = $this->getJson('/api/products');

    $response->assertStatus(200)
             ->assertJsonCount(3, 'data')
             ->assertJsonStructure(['data', 'links', 'meta']);
});

test('crear producto guarda en base de datos', function () {
    $data = [
        'name' => 'Laptop Gamer',
        'description' => 'Alta gama',
        'price' => 1500.00,
        'currency_id' => $this->currency->id,
        'tax_cost' => 150,
        'manufacturing_cost' => 800
    ];

    $this->postJson('/api/products', $data)
         ->assertStatus(201)
         ->assertJsonPath('data.name', 'Laptop Gamer');

    $this->assertDatabaseHas('products', ['name' => 'Laptop Gamer']);
});

test('mostrar producto individual funciona', function () {
    $product = Product::create([
        'name' => 'Mouse',
        'description' => 'USB',
        'price' => 20,
        'currency_id' => $this->currency->id,
        'tax_cost' => 2,
        'manufacturing_cost' => 5
    ]);

    $this->getJson("/api/products/{$product->id}")
         ->assertStatus(200)
         ->assertJsonPath('data.id', $product->id);
});

test('mostrar producto inexistente devuelve 404 limpio', function () {
    $this->getJson("/api/products/99999")
         ->assertStatus(404)
         ->assertJson(['message' => 'El registro solicitado no existe.']);
});

test('actualizar producto modifica los datos', function () {
    $product = Product::create([
        'name' => 'Mouse Viejo',
        'description' => 'USB',
        'price' => 20,
        'currency_id' => $this->currency->id,
        'tax_cost' => 2,
        'manufacturing_cost' => 5
    ]);

    $updateData = [
        'name' => 'Mouse Nuevo',
        'description' => 'Inalámbrico',
        'price' => 25,
        'currency_id' => $this->currency->id,
        'tax_cost' => 2.5,
        'manufacturing_cost' => 6
    ];

    $this->putJson("/api/products/{$product->id}", $updateData)
         ->assertStatus(200)
         ->assertJsonPath('data.name', 'Mouse Nuevo');

    $this->assertDatabaseHas('products', ['name' => 'Mouse Nuevo']);
});

test('eliminar producto usa soft deletes', function () {
    $product = Product::create([
        'name' => 'A Borrar',
        'description' => '...',
        'price' => 10,
        'currency_id' => $this->currency->id,
        'tax_cost' => 1,
        'manufacturing_cost' => 1
    ]);

    $this->deleteJson("/api/products/{$product->id}")
         ->assertStatus(200);

    $this->assertDatabaseMissing('products', ['id' => $product->id, 'deleted_at' => null]);
    
    $this->assertSoftDeleted('products', ['id' => $product->id]);
});