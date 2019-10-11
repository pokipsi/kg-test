<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'email' => $this->email,
            'subscribed' => $this->subscribed == 1,
            'required_reactivation' => $this->required_reactivation == 1,
            'deleted' => $this->deleted_at != null
        ];
    }
}
