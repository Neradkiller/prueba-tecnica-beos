<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Domains\Currency\Requests\StoreCurrencyRequest;
use App\Domains\Currency\DataTransferObjects\CurrencyData;
use App\Domains\Currency\DataTransferObjects\CurrencySearchData;
use App\Domains\Currency\Actions\GetAllCurrenciesAction;
use App\Domains\Currency\Actions\GetCurrencyAction;
use App\Domains\Currency\Actions\CreateCurrencyAction;
use App\Domains\Currency\Actions\UpdateCurrencyAction;
use App\Domains\Currency\Actions\DeleteCurrencyAction;
use App\Domains\Currency\Models\Currency; 
use App\Domains\Currency\Resources\CurrencyResource;

class CurrencyController extends Controller
{
    /**
     * GET /currencies
     * Lista paginada y filtrada.
     */
    public function index(Request $request, GetAllCurrenciesAction $action): AnonymousResourceCollection
    {
        $filters = CurrencySearchData::fromRequest($request);
        $currencies = $action->execute($filters);
        return CurrencyResource::collection($currencies);
    }

    /**
     * POST /currencies
     * Crear nueva divisa.
     */
    public function store(
        StoreCurrencyRequest $request, 
        CreateCurrencyAction $action
    ): CurrencyResource {
        $data = CurrencyData::fromRequest($request);
        $currency = $action->execute($data);

        return new CurrencyResource($currency);
    }

    /**
     * GET /currencies/{id}
     * Obtener una divisa por ID.
     */
    public function show(int $id, GetCurrencyAction $action): CurrencyResource
    {
        $currency = $action->execute($id);

        return new CurrencyResource($currency);
    }

    /**
     * PUT /currencies/{id}
     * Actualizar divisa.
     */
    public function update(
        StoreCurrencyRequest $request, 
        int $id,
        GetCurrencyAction $getAction,    
        UpdateCurrencyAction $updateAction 
    ): CurrencyResource {
        $currency = $getAction->execute($id);
        $data = CurrencyData::fromRequest($request);
        $updatedCurrency = $updateAction->execute($currency, $data);

        return new CurrencyResource($updatedCurrency);
    }

    /**
     * DELETE /currencies/{id}
     * Eliminar divisa.
     */
    public function destroy(
        int $id, 
        GetCurrencyAction $getAction, 
        DeleteCurrencyAction $deleteAction
    ): JsonResponse {
        $currency = $getAction->execute($id);
        $deleteAction->execute($currency);

        return response()->json(['message' => 'Divisa eliminada correctamente'], 200);
    }
}