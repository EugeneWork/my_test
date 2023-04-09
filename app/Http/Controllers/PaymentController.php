<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * @param PaymentService $paymentService
     */
    public function __construct(protected PaymentService $paymentService)
    {

    }
}
