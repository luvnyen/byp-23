<?php

namespace App\Http\Resources\Student;

use App\Models\Student\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $model = new Unit();

        return $model->resourceData($this);
    }
}