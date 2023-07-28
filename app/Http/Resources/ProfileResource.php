<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
   public function toArray($request)
    {
        return [
            // @TODO implement
            'username' => $this->username,
            'password' => $this->password,
            'profile_picture' => $this->profile_picture,
            'phone_number' => $this->phone_number,
            'nik' => $this->employee->nik,
            'name' => $this->employee->name,
            'age' => $this->employee->age,
            'gender' => $this->employee->gender,
            'date_of_birth' => $this->employee->date_of_birth,
            'place_of_birth' => $this->employee->place_of_birth,
            'religion' => $this->employee->religion,
//            'is_online' => $this->is_onlie,
//            'group' => $this->group->getCollect(),
//            'employee' => $this->employee->getCollect(),
        ];
    }


}
