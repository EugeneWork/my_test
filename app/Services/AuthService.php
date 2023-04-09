<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use App\Traits\ServiceResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AuthService
{
    use ServiceResponse;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @param $attributes
     * @return array
     */
    public function register($attributes): array
    {
        $user = $this->userRepository->create($attributes);
        if ($user->id) {
            return $this->success($user);
        }
        return $this->error("Can't store user");
    }


    /**
     * @param $attributes
     * @return array
     */
    public function login($attributes): array
    {
        $user = $this->userRepository->getByEmail($attributes['email']);
        if ($user) {
            if (Hash::check($attributes['password'], $user->password)) {
                $user = $this->userRepository->updateApiToken($user, Str::random(64));
                return $this->success($user);
            }
            return $this->error("Wrong password");
        }
        return $this->error("Wrong email");
    }

    /**
     * @param $token
     * @return array
     */
    public function logout($token): array
    {
        $user = $this->userRepository->getByApiToken($token);
        if ($user) {
            $user = $user->update(['api_token' => null]);
            return $this->success($user);
        }
        return $this->error("Wrong token");
    }
}
