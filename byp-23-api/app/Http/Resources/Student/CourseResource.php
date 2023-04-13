<?php

namespace App\Http\Resources\Student;

use App\Models\Student\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $model = new Course();

        return $model->resourceData($this);
    }
}