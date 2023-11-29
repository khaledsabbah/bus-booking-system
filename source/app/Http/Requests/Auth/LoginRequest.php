<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
            "login_code"=>["nullable", Rule::exists("users_verify","token")]
        ];
    }

    /**
     * This method used to add parameters to scribe documentation.
     */
    public function bodyParameters(): array
    {
        return [
            'email' => [
                'example' => 'admin@voyage.com',
            ],
            'password' => [
                'example' => 'password',
            ],
        ];
    }
}
