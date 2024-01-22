<?php

namespace App\Http\Requests\User;

use App\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => [
                'sometimes',
                'string',
            ],
            'last_name' => [
                'sometimes',
                'string',
            ],
            'email' => [
                'sometimes',
                'string',
                
            ],
            'birthday' => [
                'sometimes',
                'date',
            ],
            'account_type' => [
                'sometimes',
                'string',
            ],
            'city' => [
                'sometimes',
                'string',
            ],
            'address' => [
                'sometimes',
                'string',
            ],
            'country' => [
                'sometimes',
                'string',
            ],
            'country_code' => [
                'sometimes',
                'string',
            ],
            'phone' => [
                'sometimes',
                'string',
            ],
            'postal_code' => [
                'sometimes',
                'string',
            ],
            'image' => [
                'sometimes',
                'file',
            ],
        ];
    }
  
}
