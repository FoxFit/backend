<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
class ForceJsonResponse
{
    public function handle(Request $request, Closure $next)
    {
        if($request->getMethod() == 'OPTIONS'){
            return response()->json('{"method":"OPTIONS"}', 204, [
                'Accept' => 'application/json',
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, PATCH, DELETE',
                'Access-Control-Allow-Headers' => 'Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Authorization , Access-Control-Request-Headers',
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Expose-Headers' => 'Content-Range',
            ]);
        }

        $request->headers->set('Accept', 'application/json');
        $request->headers->set('Content-Type', 'application/json');
        $request->headers->set('Access-Control-Expose-Headers', 'Content-Range');
        return $next($request);
    }
}
