<?php

namespace App\Http\Resources\PhoneBook\Contact;

use App\Http\Resources\PhoneBook\Number\NumberResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'secondName' => $this->second_name,
            'lastName' => $this->last_name,
            'favorite' => $this->favorite,
            'numbers' => NumberResource::collection($this->numbers)
        ];
    }
}
