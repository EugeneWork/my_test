<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    /**
     * @param $email
     * @return Model|null
     */
    public function getByEmail($email): ?Model;
}
