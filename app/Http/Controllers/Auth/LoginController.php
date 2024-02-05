<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin() {
        return view('auth.auth');
    }

    public function login(LoginRequest $request){

        $user  = User::where('email',$request->email)->first();

        if($user && Hash::check($request->password,$user->password)){
            Auth::login($user);
            return redirect('/sys');
        }else {
            return  redirect()->route('login')->withErrors([
                'email' => 'Verdiginiz bilgilerle eşleşen bir kullanıcı bulunamadı'
            ])
                ->onlyInput("email");
        }

    }
}
