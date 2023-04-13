<?php

namespace App\Http\Resources\Student;

use App\Models\Student\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $model = new Student();

        return $model->resourceData($this);
    }
}