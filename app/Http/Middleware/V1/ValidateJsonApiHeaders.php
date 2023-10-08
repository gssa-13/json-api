<?php

namespace App\Http\Middleware\V1;

use Illuminate\Http\Request;

use Closure;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;

class ValidateJsonApiHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)//: Response
    {
        if ($request->header('accept') !== 'application/vnd.api+json') {
            throw new HttpException(406, __('Not Acceptable'));
        }

        if ($request->isMethod('POST') || $request->isMethod('PATCH')) {
            if ($request->header('content-type') !== 'application/vnd.api+json') {
                throw new HttpException(415, __('Unsupported Media Type'));
            }
        }

        return $next($request)->withHeaders([
            'content-type' => 'application/vnd.api+json'
        ]);
    }
}
