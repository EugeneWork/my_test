<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Interface WalletRepositoryInterface
 * @package App\Repositories
 */
interface WalletRepositoryInterface
{
    /**
     * @param $user_id
     * @param $currency_id
     * @return Model|null
     */
    public function findByUserAndCurrency($user_id, $currency_id):?Model;
}
