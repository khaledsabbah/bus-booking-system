<?php

namespace App\Http\Requests\Trip;

use App\Http\Requests\BaseRequest;

class UpdateTripRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
