<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(AuthService $service)
    {
        parent::__construct($service);
    }

    public function register(RegisterUserRequest $request)
    {
        return $this->service->register($request);
    }

    public function login(LoginUserRequest $request) {
        return $this->service->login($request);
    }

    public function logout(Request $request) {
        return $this->service->logout($request);
    }
}
