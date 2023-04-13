<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ValidateUUID
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        foreach ($request->route()->parameters() as $key => $value) {
            if (strpos(strtolower($key), 'id') !== false) {
                $validator = Validator::make(
                    [$key => $value],
                    [$key => 'uuid'],
                    [$key.'.uuid' => "$key bukan merupakan UUID yang valid"]
                );

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }
            }
        }

        return $next($request);
    }
}
