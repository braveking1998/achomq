<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'status' => $this->status,
            'answers' => AnswerResource::collection($this->answers),
            'category' => new CategoryResource(Category::findOrFail($this->category_id)),
            'level' => new LevelResource(Level::findOrFail($this->level_id)),
            'created_at' => $this->created_at,
        ];
    }
}
