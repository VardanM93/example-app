<?php

namespace App\Http\Resources;

/**
 * Class ProductResource
 * @package App\Http\Resources
 *
 */
class ProductResource extends BaseResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'image' => $this->resource->image
        ];
    }
}
