<?php

namespace App\Repositories\Eloquent;

use App\Models\PaymentHistory;
use App\Repositories\PaymentRepositoryInterface;

class PaymentRepository extends BaseRepository implements PaymentRepositoryInterface
{
    /**
     * @param PaymentHistory $model
     */
    public function __construct(PaymentHistory $model)
    {
        parent::__construct($model);
    }
}
