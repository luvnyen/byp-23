<?php

namespace App\Models\Student;

use App\Http\Resources\Student\UnitResource;
use App\Repositories\Student\UnitRepository;
use App\Services\Student\UnitService;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Unit extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public static function validationRules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
            ],
        ];
    }

    public static function validationMessages()
    {
        return [
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus berupa string',
            'name.max' => 'Nama maksimal 100 karakter',
        ];
    }

    public function test()
    {
        return [
            'name' => Str::random(5),
        ];
    }

    public function resourceData($request)
    {
        return [
            'id' => $request->id,
            'name' => $request->name,
        ];
    }

    public function controller()
    {
        return 'App\Http\Controllers\Student\UnitController';
    }

    public function service()
    {
        return new UnitService($this);
    }

    public function repository()
    {
        return new UnitRepository($this);
    }

    public function resource()
    {
        return new UnitResource($this);
    }

    /*
        Define Relationships
    */
}
