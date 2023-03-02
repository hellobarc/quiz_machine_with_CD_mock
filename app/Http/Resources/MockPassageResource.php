<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MockPassageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'mock_exercise_id' => $this->mock_exercise_id,
            'title' => $this->title,
            'passage' => $this->passage,
            'image' => $this->image,
        ];


    }
}
