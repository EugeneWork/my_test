<?php

namespace App\Http\Controllers;

use App\Services\CurrencyService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    use ApiResponse;

    public function __construct(protected CurrencyService $currencyService)
    {

    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $currencies = $this->currencyService->index();
        return $this->responseSuccess('Success', $currencies['body']);
    }
}
