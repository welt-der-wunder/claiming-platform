<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Foundation\Http\FormRequest;
class ConnectWalletRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'signature' => [
                'required',
            ],
            'public_address' => [
                'required',
            ],
        ];
    }
}
