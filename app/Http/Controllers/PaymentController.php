<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Services\PaymentService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use ApiResponse;

    /**
     * @param PaymentService $paymentService
     */
    public function __construct(protected PaymentService $paymentService)
    {

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $history = $this->paymentService->index($request->user()->id);
        return $this->responseSuccess('Success', $history['body']);
    }

    /**
     * @param StorePaymentRequest $request
     * @return JsonResponse
     */
    public function store(StorePaymentRequest $request): JsonResponse
    {
        $topUp = $this->paymentService->store($request);
        if ($topUp['status'] == 'Success') {
            return $this->responseSuccess('Success', $topUp);
        }
        return $this->responseServerError($topUp['message']);
    }

}
