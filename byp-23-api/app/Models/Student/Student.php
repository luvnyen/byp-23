<?php

namespace App\Models\Student;

use Illuminate\Support\Str;
use App\Models\Student\Unit;
use Illuminate\Database\Eloquent\Model;
use App\Services\Student\StudentService;
use App\Http\Resources\Student\UnitResource;
use App\Http\Resources\Student\StudentResource;
use App\Repositories\Student\StudentRepository;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'nrp',
        'name',
        'unit_id',
    ];

    public static function validationRules()
    {
        return [
            'nrp' => [
                'required',
                'string',
                'min:9',
                'max:9',
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
            'nrp.required' => 'NRP harus diisi',
            'nrp.string' => 'NRP harus berupa string',
            'nrp.min' => 'NRP harus berjumlah 9 karakter',
            'nrp.max' => 'NRP harus berjumlah 9 karakter',
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus berupa string',
            'name.max' => 'Nama maksimal 100 karakter',
        ];
    }

    public function test()
    {
        $unit = new Unit();
        $unit = $unit::create($unit->test());

        return [
            'nrp' => Str::random(9),
            'name' => Str::random(5),
            'unit_id' => $unit->id,
        ];
    }

    public function resourceData($request)
    {
        return [
            'id' => $request->id,
            'nrp' => $request->nrp,
            'name' => $request->name,
            'unit' => new UnitResource($request->unit),
        ];
    }

    public function controller()
    {
        return 'App\Http\Controllers\Student\StudentController';
    }

    public function service()
    {
        return new StudentService($this);
    }

    public function repository()
    {
        return new StudentRepository($this);
    }

    public function resource()
    {
        return new StudentResource($this);
    }

    /*
        Define Relationships
    */

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
