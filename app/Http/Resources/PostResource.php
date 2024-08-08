<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user" => $this->user->name,    
            "title" => $this->title,
            "body" => $this->body,
            "path" => $this->path(),
            "created_at" => $this->created_at->toFormattedDateString()
        ];
    }
}
