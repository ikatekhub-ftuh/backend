<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_user' => $this->id_user,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'last_active' => $this->last_active,
            'is_admin' => $this->is_admin,
            'alumni' => new AlumniResource($this->alumni),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
