<?php

namespace App\Repositories\Eloquent;

use App\Models\Wallet;
use App\Repositories\WalletRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class WalletRepository extends BaseRepository implements WalletRepositoryInterface
{
    /**
     * @param Wallet $model
     */
    public function __construct(Wallet $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $user_id
     * @param $currency_id
     * @return Model|null
     */
    public function findByUserAndCurrency($user_id, $currency_id): ?Model
    {
        return $this->model->where('user_id',$user_id)->where('currency_id',$currency_id)->first();
    }
}
