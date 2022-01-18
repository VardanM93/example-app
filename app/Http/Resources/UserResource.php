<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $email
 * @property mixed $token
 */
class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'token'  => $this->token
        ];
    }
}
