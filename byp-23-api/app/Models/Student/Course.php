<?php

namespace App\Models\Student;

use App\Http\Resources\Student\CourseResource;
use App\Http\Resources\Student\UnitResource;
use App\Models\ModelUtils;
use App\Repositories\Student\CourseRepository;
use App\Services\Student\CourseService;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'unit_id',
    ];

    public static function validationRules()
    {
        return [
            'code' => [
                'required',
                'string',
                'max:10',
            ],
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'unit_id' => [
                'required',
                'uuid',
            ],
        ];
    }

    public static function validationMessages()
    {
        return [
            'code.required' => 'Kode harus diisi',
            'code.string' => 'Kode harus berupa string',
            'code.max' => 'Kode maksimal 10 karakter',
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus berupa string',
            'name.max' => 'Nama maksimal 100 karakter',
            'unit_id.required' => 'Unit harus diisi',
            'unit_id.uuid' => 'Unit harus berupa UUID',
        ];
    }

    public function test()
    {
        $unit = new Unit();
        $unit = $unit::create($unit->test());

        return [
            'code' => Str::random(5),
            'name' => Str::random(5),
            'unit_id' => $unit->id,
        ];
    }

    public function resourceData($request)
    {
        return ModelUtils::filterNullValues([
            'id' => $request->id,
            'code' => $request->code,
            'name' => $request->name,
            'unit' => new UnitResource($request->unit),
        ]);
    }

    public function controller()
    {
        return 'App\Http\Controllers\Student\CourseController';
    }

    public function service()
    {
        return new CourseService($this);
    }

    public function repository()
    {
        return new CourseRepository($this);
    }

    public function resource()
    {
        return new CourseResource($this);
    }

    /*
        Define Relationships
    */

    public function relations()
    {
        return [
            'unit'
        ];
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
