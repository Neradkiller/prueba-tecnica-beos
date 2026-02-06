<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Domains\Product\Models\Product; 
use App\Domains\Currency\Requests\StoreProductPriceRequest;
use App\Domains\Currency\Actions\RegisterProductPriceAction;
use App\Domains\Currency\DataTransferObjects\ProductPriceData;
use App\Domains\Currency\Resources\ProductPriceResource;

class ProductPriceController extends Controller
{

    public function index(int $productId): JsonResponse
    {
        $product = Product::with('prices.currency')->findOrFail($productId);
        
        return response()->json(
            ProductPriceResource::collection($product->prices)
        );
    }


    public function store(
        StoreProductPriceRequest $request, 
        int $productId, 
        RegisterProductPriceAction $action
    ): JsonResponse {
        Product::findOrFail($productId);

        $data = ProductPriceData::fromRequest($request, $productId);
        $productPrice = $action->execute($data);

        return response()->json(new ProductPriceResource($productPrice), 201);
    }

}