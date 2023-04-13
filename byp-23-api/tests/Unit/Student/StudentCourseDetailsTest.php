<?php

namespace Tests\Student;

use App\Models\Student\StudentCourseDetails;
use App\Utils\HttpResponseCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class StudentCourseDetailsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $model;

    protected $test;

    protected $route;

    public function setUp(): void
    {
        parent::setUp();

        // $this->withoutExceptionHandling();

        $this->model = new StudentCourseDetails();
        $this->test = $this->model->test();
        $this->route = $this->setModelRoute($this->model);
    }

    public function testGetAll()
    {
        $res = $this->get($this->route);

        $this->assertNotNull($res);
        $this->assertEquals(HttpResponseCode::HTTP_OK, $res->getStatusCode());
    }

    public function testGetById()
    {
        $model = $this->model::create($this->test);

        $res = $this->get($this->route . '/' . $model->id);

        $this->assertNotNull($res);
        $this->assertEquals(HttpResponseCode::HTTP_OK, $res->getStatusCode());

        foreach ($this->model->getFillable() as $fillable) {
            if (strpos($fillable, '_id') === false && isset($this->test[$fillable])) {
                $this->assertEquals($this->test[$fillable], $res->getData()->data->$fillable);
            }
        }
    }

    public function testGetByIdNotFound()
    {
        $res = $this->get($this->route . '/' . Uuid::uuid4()->toString());

        $this->assertNotNull($res);
        $this->assertEquals(HttpResponseCode::HTTP_NOT_FOUND, $res->getStatusCode());
    }

    public function testGetByIdInvalidFormat()
    {
        $res = $this->get($this->route . '/' . Uuid::uuid4()->toString());

        $this->assertNotNull($res);
        $this->assertEquals(HttpResponseCode::HTTP_NOT_FOUND, $res->getStatusCode());
    }

    public function testCreate()
    {
        $res = $this->post($this->route, $this->test);

        $this->assertNotNull($res);
        $this->assertEquals(HttpResponseCode::HTTP_CREATED, $res->getStatusCode());

        foreach ($this->model->getFillable() as $fillable) {
            if (strpos($fillable, '_id') === false && isset($this->test[$fillable])) {
                $this->assertEquals($this->test[$fillable], $res->getData()->data->$fillable);
            }
        }
    }

    public function testCreateDataExist()
    {
        $this->model::create($this->test);

        $res = $this->post($this->route, $this->test);

        $this->assertNotNull($res);
        $this->assertEquals(HttpResponseCode::HTTP_CONFLICT, $res->getStatusCode());
    }

    public function testCreateMissingField()
    {
        $res = $this->post($this->route, []);

        $this->assertNotNull($res);
        $this->assertEquals(HttpResponseCode::HTTP_BAD_REQUEST, $res->getStatusCode());
    }

    public function testUpdate()
    {
        $model = $this->model::create($this->test);

        $res = $this->put($this->route . '/' . $model->id, $this->test);

        $this->assertNotNull($res);
        $this->assertEquals(HttpResponseCode::HTTP_OK, $res->getStatusCode());

        foreach ($this->model->getFillable() as $fillable) {
            if (strpos($fillable, '_id') === false && isset($this->test[$fillable])) {
                $this->assertEquals($this->test[$fillable], $res->getData()->data->$fillable);
            }
        }
    }

    public function testUpdateNotFound()
    {
        $res = $this->put($this->route . '/' . Uuid::uuid4()->toString(), $this->test);

        $this->assertNotNull($res);
        $this->assertEquals(HttpResponseCode::HTTP_NOT_FOUND, $res->getStatusCode());
    }

    public function testUpdateInvalidFormat()
    {
        $res = $this->put($this->route . '/' . Str::random(10), $this->test);

        $this->assertNotNull($res);
        $this->assertEquals(HttpResponseCode::HTTP_BAD_REQUEST, $res->getStatusCode());
    }

    public function testUpdateMissingField()
    {
        $model = $this->model::create($this->test);

        $res = $this->put($this->route . '/' . $model->id, []);

        $this->assertNotNull($res);
        $this->assertEquals(HttpResponseCode::HTTP_BAD_REQUEST, $res->getStatusCode());
    }

    public function testDelete()
    {
        $model = $this->model::create($this->test);

        $res = $this->delete($this->route . '/' . $model->id);

        $this->assertNotNull($res);
        $this->assertEquals(HttpResponseCode::HTTP_NO_CONTENT, $res->getStatusCode());
    }

    public function testDeleteNotFound()
    {
        $res = $this->delete($this->route . '/' . Uuid::uuid4()->toString());

        $this->assertNotNull($res);
        $this->assertEquals(HttpResponseCode::HTTP_NOT_FOUND, $res->getStatusCode());
    }

    public function testDeleteInvalidFormat()
    {
        $res = $this->delete($this->route . '/' . Str::random(10));

        $this->assertNotNull($res);
        $this->assertEquals(HttpResponseCode::HTTP_BAD_REQUEST, $res->getStatusCode());
    }
}