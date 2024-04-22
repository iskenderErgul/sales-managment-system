<?php

namespace App\Http\Repositories;

use App\DTOs\LoginUserDTO;
use App\Interfaces\UserInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserRepository implements UserInterface
{

    public function login(LoginUserDTO $userDTO): JsonResponse
    {
        $userControl = [
            'email' => $userDTO->email,
            'password' => $userDTO->password,
        ];

        if (Auth::attempt($userControl)) {

            return response()->json(Auth::user(),'200');
        } else {
            return response()->json('Giriş Başarısız', 401);
        }
    }

    public function logout(): JsonResponse
    {
        Session::flush();
        return response()->json('Çıkış İşlemi Başarılı');
    }
}
