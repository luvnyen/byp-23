<?php

namespace App\Exceptions;

use App\Utils\HttpResponse;
use App\Utils\HttpResponseCode;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    use HttpResponse;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            $model = class_basename($e->getModel());

            return $this->error(
                "{$model} tidak ditemukan",
                HttpResponseCode::HTTP_NOT_FOUND
            );
        } else {
            switch (true) {
                case $e instanceof \Illuminate\Validation\ValidationException:
                    return $this->error(
                        $e->validator->errors(),
                        HttpResponseCode::HTTP_BAD_REQUEST
                    );
                case $e instanceof \Illuminate\Auth\Access\AuthorizationException:
                    return $this->error(
                        'Anda tidak memiliki hak akses',
                        HttpResponseCode::HTTP_UNAUTHORIZED
                    );
                case $e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException:
                    return $this->error(
                        'Metode tidak diizinkan',
                        HttpResponseCode::HTTP_METHOD_NOT_ALLOWED
                    );
                case $e instanceof \Symfony\Component\HttpKernel\Exception\BadRequestHttpException:
                    return $this->error(
                        'Bad request',
                        HttpResponseCode::HTTP_BAD_REQUEST
                    );
                case $e instanceof \Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException:
                    return $this->error(
                        'Terlalu banyak requests',
                        HttpResponseCode::HTTP_TOO_MANY_REQUESTS
                    );
                case $e instanceof \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException:
                    return $this->error(
                        'Terlarang',
                        HttpResponseCode::HTTP_FORBIDDEN
                    );
                case $e instanceof \Symfony\Component\HttpKernel\Exception\ConflictHttpException:
                    return $this->error(
                        'Data telah tersedia',
                        HttpResponseCode::HTTP_CONFLICT
                    );
                case $e instanceof \Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException:
                    return $this->error(
                        'Jenis media tidak didukung',
                        HttpResponseCode::HTTP_UNSUPPORTED_MEDIA_TYPE
                    );
                case $e instanceof \Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException:
                    return $this->error(
                        'Entitas tidak dapat diproses',
                        HttpResponseCode::HTTP_UNPROCESSABLE_ENTITY
                    );
                case $e instanceof \Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException:
                    return $this->error(
                        'Servis tidak tersedia',
                        HttpResponseCode::HTTP_SERVICE_UNAVAILABLE
                    );
                case $e instanceof \Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException:
                    return $this->error(
                        'Tidak dapat diterima',
                        HttpResponseCode::HTTP_NOT_ACCEPTABLE
                    );
                case $e instanceof \Illuminate\Database\QueryException:
                    switch ($e->getCode()) {
                        case '23503':
                            $field = ExceptionUtils::getErrorFieldName($e);
                            $value = ExceptionUtils::getErrorFieldValue($e);

                            return $this->error(
                                'Data tidak ditemukan untuk '.$field.' = '.$value,
                                HttpResponseCode::HTTP_UNPROCESSABLE_ENTITY
                            );
                        case '23505':
                            $field = ExceptionUtils::getErrorFieldName($e);
                            $value = ExceptionUtils::getErrorFieldValue($e);

                            return $this->error(
                                'Data telah tersedia untuk '.$field.' = '.$value,
                                HttpResponseCode::HTTP_CONFLICT
                            );
                        default:
                            return $this->error(
                                $e->getMessage(),
                                HttpResponseCode::HTTP_INTERNAL_SERVER_ERROR
                            );
                    }
                default:
                    return $this->error(
                        $e->getMessage(),
                        HttpResponseCode::HTTP_INTERNAL_SERVER_ERROR
                    );
            }
        }

        return parent::render($request, $e);
    }
}
