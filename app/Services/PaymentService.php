<?php

namespace App\Services;

use App\Repositories\PaymentRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Traits\ServiceResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class PaymentService
{
    use ServiceResponse;

    /**
     * @param PaymentRepositoryInterface $paymentRepository
     */
    public function __construct(protected PaymentRepositoryInterface $paymentRepository)
    {
    }

}
