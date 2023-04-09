<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RecoverPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UserStoreRequest;
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


    public function store(Request $request): JsonResponse
    {
        $user = $this->authService->register([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'password' => Hash::make($request->get('password')),
        ]);
        if ($user['status'] == 'Success') {
            return $this->responseSuccess('Success', ['user' => $user['body']]);
        }
        return $this->responseServerError($user['message']);
    }


    public function login(Request $request): JsonResponse
    {
        $login = $this->authService->login([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);
        if ($login['status'] == 'Success') {
            return $this->responseSuccess('Success', ['user' => $login['body']]);
        }
        return $this->responseNotFound($login['message']);
    }


    public function logout(Request $request): JsonResponse
    {
        $logout = $this->authService->logout($request->user->api_token);
        if ($logout['status'] == 'Success') {
            return $this->responseSuccess('Success', $logout['body']);
        }
        return $this->responseNotFound($logout['message']);
    }
}
