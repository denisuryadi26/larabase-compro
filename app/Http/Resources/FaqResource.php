<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
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
            // @TODO implement
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'content_head' => $this->content_head,
            'content_detail' => $this->content_detail,
            'created_at' => date_format($this->created_at,"Y-m-d H:i:s"),
        ];

    }
}
