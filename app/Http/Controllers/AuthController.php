<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * @param AuthService $authService
     */
    public function __construct(protected AuthService $authService)
    {

    }

    /**
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->only('name', 'email', 'phone', 'address', 'password'));
        if ($user['status'] == 'Success') {
            return $this->responseSuccess('Success', ['user' => $user['body']]);
        }
        return $this->responseServerError($user['message']);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $login = $this->authService->login($request->only('email', 'password'));
        if ($login['status'] == 'Success') {
            return $this->responseSuccess('Success', ['user' => $login['body']]);
        }
        return $this->responseNotFound($login['message']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $logout = $this->authService->logout($request);
        if ($logout['status'] == 'Success') {
            return $this->responseSuccess('Success', $logout['body']);
        }
        return $this->responseNotFound($logout['message']);
    }
}
