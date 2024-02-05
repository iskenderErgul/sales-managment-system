<?php

namespace App\Http\Requests\Login;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'email'=> ['required','email','exists:users'],
            'password' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'email.exists' => 'Bilgilerinizi Kontrol ediniz'
        ];
    }
}
