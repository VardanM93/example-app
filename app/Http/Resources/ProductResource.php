<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $image
 * @property mixed $description
 * @property mixed $name
 * @property mixed $user_id
 * @property mixed $id
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param $request
     * @return array
     */

    public function toArray($request): array
    {
        return [

            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image
        ];
    }
}
