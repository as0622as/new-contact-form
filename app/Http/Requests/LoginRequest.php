<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    // 認証前にこのリクエストが許可されるか
    public function authorize(): bool
    {
        return true; // 認証前なので true
    }

    // バリデーションルール
    public function rules(): array
    {
        return [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ];
    }
}
