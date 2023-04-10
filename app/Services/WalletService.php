<?php

namespace App\Services;

use App\Repositories\WalletRepositoryInterface;
use App\Traits\ServiceResponse;
class WalletService
{
    use ServiceResponse;

    /**
     * @param WalletRepositoryInterface $walletRepository
     */
    public function __construct(protected WalletRepositoryInterface $walletRepository)
    {
    }

    /**
     * @param $user_id
     * @return array
     */
    public function getWallets($user_id): array
    {
        $this->walletRepository->relations = ['currency'];
        return $this->success($this->walletRepository->where('user_id', $user_id)->get());
    }

    /**
     * @param $user_id
     * @param $currency_id
     * @return array
     */
    public function findByUserAndCurrency($user_id, $currency_id): array
    {
        $wallet = $this->walletRepository->findByUserAndCurrency($user_id, $currency_id);
        if ($wallet) {
            return $this->success($wallet);
        }
        return $this->error("Not found");
    }

    /**
     * @param $attributes
     * @return array
     */
    public function create($attributes): array
    {
        $wallet = $this->walletRepository->create($attributes);
        if ($wallet->id) {
            return $this->success($wallet);
        }
        return $this->error("Can't create wallet");
    }

}
