<?php

namespace App\Repositories\Eloquent;

use App\Models\Currency;
use App\Repositories\CurrencyRepositoryInterface;

class CurrencyRepository extends BaseRepository implements CurrencyRepositoryInterface
{
    /**
     * @param Currency $model
     */
    public function __construct(Currency $model)
    {
        parent::__construct($model);
    }
}
