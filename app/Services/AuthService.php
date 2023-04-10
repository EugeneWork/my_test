<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use App\Traits\ServiceResponse;
use Illuminate\Support\Facades\Hash;

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
        $attributes['password'] = Hash::make($attributes['password']);
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
        $user = $this->userRepository->where('email', $attributes['email'])->first();
        if ($user) {
            if (Hash::check($attributes['password'], $user->password)) {
                return $this->success($user->createToken("API TOKEN")->plainTextToken);
            }
            return $this->error("Wrong password");
        }
        return $this->error("Wrong email");
    }


    /**
     * @param $request
     * @return array
     */
    public function logout($request): array
    {
        $user = $request->user()->currentAccessToken()->delete();
        return $this->success($user);
    }
}
