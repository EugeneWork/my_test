<?php

namespace App\Services;

use App\Repositories\CurrencyRepositoryInterface;
use App\Traits\ServiceResponse;
class CurrencyService
{
    use ServiceResponse;

    /**
     * @param CurrencyRepositoryInterface $currencyRepository
     */
    public function __construct(protected CurrencyRepositoryInterface $currencyRepository)
    {
    }

    /**
     * @return array
     */
    public function index(): array
    {
        return $this->success($this->currencyRepository->get());
    }

}
