<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\LoginUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\Login\LoginRequest;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    protected UserRepository $userRepository;
    public function __construct(UserRepository  $userRepository)
    {
        $this->userRepository  = $userRepository;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->userRepository->login(LoginUserDTO::buildFromRequest($request));
        return response()->json($user);
    }
    public function logout(): JsonResponse
    {
        return $this->userRepository->logout();
    }
}
