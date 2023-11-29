<?php

namespace App\Http\Resources;

use \App\Libs\Transformers\DateFormatter;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => DateFormatter::make($this->created_at),
        ];
    }
}
