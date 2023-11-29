<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use YlsIdeas\FeatureFlags\Facades\Features;
use App\Enums\UserType;

class StoreUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'=> ['required', 'email', Rule::unique('users', 'email')->withoutTrashed()],
            'password' => ['required', 'confirmed', "min:6"],
            'profile_picture' => 'mimes:jpeg,jpg,bmp,png,gif',
            'type'=>'required||in:'.implode(",", UserType::names()),
            'name' => 'required|string|min:1|max:100',
            'first_name' => 'required|string|min:1|max:100',
            'last_name' => 'required|string|min:1|max:100',
            'country_id' => 'required|exists:countries,id',
            'phone' => 'required|numeric',
            'entity_name' => 'required|string',
            'website_url' => 'required|string|url',
            "cr_attachment"=>"required|file|mimes:pdf",
            "profile_attachment"=>"required|file|mimes:pdf"
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.email' => __('Make sure to write legal email format'),
            'email.unique' => __('This email has already been added in the system, Try to reset your password'),
        ];
    }
}
