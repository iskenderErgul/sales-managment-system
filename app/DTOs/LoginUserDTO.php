<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class LoginUserDTO
{
    public ?string $email;
    public string $password;

    public static function buildFromRequest(Request $request): self
    {
        $loginUserDTO = new self();
        $loginUserDTO->email = $request->email;
        $loginUserDTO->password = $request->password;
        return $loginUserDTO;
    }
}
