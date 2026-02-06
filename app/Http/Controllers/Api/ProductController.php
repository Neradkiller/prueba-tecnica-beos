<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; 
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Domains\Product\Requests\StoreProductRequest; 
use App\Domains\Product\DataTransferObjects\ProductData;
use App\Domains\Product\DataTransferObjects\ProductSearchData;
use App\Domains\Product\Actions\GetAllProductsAction;
use App\Domains\Product\Actions\GetProductAction; 
use App\Domains\Product\Actions\CreateProductAction;
use App\Domains\Product\Actions\UpdateProductAction;
use App\Domains\Product\Actions\DeleteProductAction;
use App\Domains\Product\Resources\ProductResource;

class ProductController extends Controller
{

    public function index(Request $request, GetAllProductsAction $action): AnonymousResourceCollection
    {
        $filters = ProductSearchData::fromRequest($request);
        
        return ProductResource::collection(
            $action->execute($filters)
        );
    }


    public function store(
        StoreProductRequest $request, 
        CreateProductAction $action
    ): JsonResponse { 
        $data = ProductData::fromRequest($request);
        $product = $action->execute($data);
        return (new ProductResource($product))
            ->response()
            ->setStatusCode(201);
    }

    public function show(int $id, GetProductAction $action): ProductResource
    {
        $product = $action->execute($id);
    
        $product->load('prices'); 

        return new ProductResource($product);
    }

    public function update(
        StoreProductRequest $request, 
        int $id,
        GetProductAction $getAction,
        UpdateProductAction $updateAction
    ): ProductResource {
        $product = $getAction->execute($id);
        $data = ProductData::fromRequest($request);
        $updatedProduct = $updateAction->execute($product, $data);

        return new ProductResource($updatedProduct);
    }


    public function destroy(
        int $id, 
        GetProductAction $getAction, 
        DeleteProductAction $deleteAction
    ): JsonResponse {
        $product = $getAction->execute($id);
        $deleteAction->execute($product);

        return response()->json(['message' => 'Producto eliminado correctamente'], 200);
    }
}