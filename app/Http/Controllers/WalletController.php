<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWalletRequest;
use App\Services\WalletService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    use ApiResponse;

    public function __construct(protected WalletService $walletService)
    {

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $wallets = $this->walletService->getWallets($request->user()->id);
        return $this->responseSuccess('Success', $wallets['body']);
    }

    /**
     * @param StoreWalletRequest $request
     * @return JsonResponse
     */
    public function store(StoreWalletRequest $request): JsonResponse
    {
        $wallet = $this->walletService->findByUserAndCurrency($request->user()->id, $request->get('currency_id'));
        if ($wallet['status'] == 'Success') {
            return $this->responseServerError("You already have wallet with current currency");
        }
        $wallet = $this->walletService->create([
            'user_id' => $request->user()->id,
            'currency_id' => $request->get('currency_id'),
            'value' => 0
        ]);
        if ($wallet['status'] == 'Success') {
            return $this->responseSuccess('Success', $wallet['body']);
        }
        return $this->responseServerError($wallet['message']);
    }
}
