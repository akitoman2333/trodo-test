<?php

namespace App\API\V1\Controllers;

use App\API\V1\Requests\Currency\FilterCurrencies;
use App\API\V1\Services\CurrenciesServices;
use App\API\V1\Traits\ApiResponseTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrenciesController extends Controller
{
    use ApiResponseTrait;

    private CurrenciesServices $currencies;

    /**
     * @param CurrenciesServices $currenciesServices
     */
    public function __construct(CurrenciesServices $currenciesServices)
    {
        $this->currencies = $currenciesServices;
    }

    /**
     * @OA\Get(
     *      path="/currencies/{fromCurrency}/{toCurrency}",
     *      tags={"Currencies"},
     *      security={{ "Bearer":{} }},
     *      summary="Get the currencies from one currency to another.",
     *      description="Retrieves the currencies from the specified source currency to the specified target currency.",
     *      @OA\Parameter(
     *          name="fromCurrency",
     *          in="path",
     *          description="The source currency.",
     *          required=true,
     *          example="EUR"
     *      ),
     *      @OA\Parameter(
     *          name="toCurrency",
     *          in="path",
     *          description="The target currency.",
     *          required=true,
     *          example="USD"
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Page number.",
     *          required=true,
     *          example=1
     *      ),
     *      @OA\Parameter(
     *          name="order",
     *          in="query",
     *          description="Sort by creation date.",
     *          required=true,
     *          example="asc"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful response",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(property="data", ref="#/definitions/CurrencyResource"),
     *              @OA\Property(property="message", type="string", example="Success")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Invalid request")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Internal server error")
     *          )
     *      )
     * )
     *
     * Get the currencies from one currency to another.
     *
     * @param string $fromCurrency The source currency.
     * @param string $toCurrency The target currency.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(FilterCurrencies $request, $fromCurrency, $toCurrency): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->respondWithResource(JsonResource::make(
                $this->currencies->getCurrencies($request->validated(), $fromCurrency, $toCurrency)
            ), 'Success');
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }
}
