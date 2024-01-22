<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Foundation\Http\FormRequest;

class RegisterSecondStepUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => [
                'required',
                'email:rfc,dns',
                'unique:users',
            ],
            'username' => [
                'required',
                'min:3',
            ],
        ];
    }
}
