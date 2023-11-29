<?php

namespace App\Http\Requests\Trip;

use App\Http\Requests\BaseRequest;

class StoreTripRequest extends BaseRequest
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
