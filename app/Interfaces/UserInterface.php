<?php

namespace App\Interfaces;

use App\DTOs\LoginUserDTO;
use Illuminate\Http\JsonResponse;

interface UserInterface
{
    public function login(LoginUserDTO $userDTO): JsonResponse ;

    public function logout(): JsonResponse ;
}
