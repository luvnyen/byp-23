<?php

namespace App\Repositories\Student;

use App\Models\Student\StudentCourseDetails;
use App\Repositories\BaseRepository;

class StudentCourseDetailsRepository extends BaseRepository
{
    public function __construct(StudentCourseDetails $model)
    {
        parent::__construct($model);
    }

    /*
        Add new repositories
        OR
        Override existing repository here...
    */

    public function getByStudentId($studentId)
    {
        $res = $this->model
            ->with([
                'student' => function ($query) {
                    $query->with([
                        'unit' => function ($query) {
                            $query->select(
                                'id',
                                'name'
                            );
                        },
                    ])
                        ->select(
                            'id',
                            'nrp',
                            'name',
                            'unit_id'
                        );
                },
                'course' => function ($query) {
                    $query->select(
                        'id',
                        'code',
                        'name'
                    );
                },
            ])
            ->select(
                'id',
                'student_id',
                'course_id',
            )
            ->where('student_id', $studentId)
            ->get();

        if ($res->isEmpty()) {
            return [];
        }

        // return $res;

        return [
            'id' => $res->first()->id,
            'student' => [
                'id' => $res->first()->student->id,
                'nrp' => $res->first()->student->nrp,
                'name' => $res->first()->student->name,
                'unit' => [
                    'id' => $res->first()->student->unit->id,
                    'name' => $res->first()->student->unit->name,
                ],
            ],
            'courses' => $res->map(function ($item) {
                return [
                    'id' => $item->course->id,
                    'code' => $item->course->code,
                    'name' => $item->course->name,
                ];
            }),
        ];
    }
}
