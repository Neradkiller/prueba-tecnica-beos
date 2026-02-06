<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

test('rate limiter blocks excessive requests', function () {

    Route::get('/api/test-throttle', function () {
        return 'ok';
    })->middleware('throttle:api');

    for ($i = 0; $i < 60; $i++) {
        $this->get('/api/test-throttle')->assertOk();
    }


    $this->get('/api/test-throttle')
         ->assertStatus(429); 
});

test('cors headers are present in response', function () {

    $origin = 'http://localhost:3000';
    Config::set('cors.allowed_origins', [$origin]);

    $response = $this->optionsJson('/api/products', [], [
        'Origin' => $origin,
        'Access-Control-Request-Method' => 'GET',
    ]);

    $response->assertStatus(204)
             ->assertHeader('Access-Control-Allow-Origin', $origin)
             ->assertHeader('Access-Control-Allow-Methods');
});