<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        dd($this);
        return [
            // @TODO implement
            'username' => $this->username,
            'password' => $this->password,
            'profile_picture' => $this->profile_picture,
            'phone_number' => $this->phone_number,
            'approval_status' => $this->approval_status,
        ];
    }
}
