<?php

namespace App\Http\Resources\Student;

use App\Models\Student\StudentCourseDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentCourseDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $model = new StudentCourseDetails();

        return $model->resourceData($this);
    }
}