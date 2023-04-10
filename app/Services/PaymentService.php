<?php

namespace App\Services;

use App\Repositories\PaymentRepositoryInterface;
use App\Repositories\WalletRepositoryInterface;
use App\Traits\ServiceResponse;

class PaymentService
{
    use ServiceResponse;

    /**
     * @param PaymentRepositoryInterface $paymentRepository
     * @param WalletRepositoryInterface $walletRepository
     */
    public function __construct(protected PaymentRepositoryInterface $paymentRepository,
                                protected WalletRepositoryInterface  $walletRepository)
    {
    }

    /**
     * @param $request
     * @return array
     */
    public function store($request): array
    {
        $wallet = $this->walletRepository->where('user_id', $request->user()->id)
            ->where('currency_id', $request->get('currency_id'))->first();
        if ($wallet) {
            if ($request->get('operation') == 'withdraw') {
                if ($wallet->value - $request->get('value') < 0) {
                    return $this->error("You don't have money for this operations");
                }
                $this->paymentRepository->create([
                    'user_id' => $request->user()->id,
                    'wallet_id' => $wallet->id,
                    'operation' => 'withdraw',
                    'value' => $request->get('value')
                ]);
                $wallet->value -= $request->get('value');
                $wallet->save();
                return $this->success('Success');
            }
            $this->paymentRepository->create([
                'user_id' => $request->user()->id,
                'wallet_id' => $wallet->id,
                'operation' => 'top_up',
                'value' => $request->get('value')
            ]);
            $wallet->value += $request->get('value');
            $wallet->save();
            return $this->success('Success');
        }
        return $this->error("Pls create wallet with currency you want top up");
    }

    /**
     * @param $user_id
     * @return array|null
     */
    public function index($user_id): array
    {
        $this->paymentRepository->relations = ['user', 'wallet.currency'];
        return $this->success($this->paymentRepository->where('user_id', $user_id)
            ->orderByDesc('created_at')->get());
    }
}
