<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 14.12.22
 * Time: 14.05
 */


namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Tymon\JWTAuth\JWTAuth;

class AddToken
{
    public function handle($request, Closure $next)
    {
        //var_dump(21123);die();
        $token = Cache::store('file')->get('jwt_token');
        //var_dump($token);die();
        $request->headers->set("Authorization", "Bearer $token");//this is working
        //$request->headers->set("Authorization", "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTY3MTAxOTYwMCwiZXhwIjoxNjcxMDIzMjAwLCJuYmYiOjE2NzEwMTk2MDAsImp0aSI6Ik1JdnIwS29Bb1BvYUVMa2kiLCJzdWIiOjEsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.2nQ2Q2Gq3lI8WhPCt67PqjuymK9yOmJgQqtinduRfqw");//this is working
        //$request->headers->set("Authorization", "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTY3MTA0ODI5MiwiZXhwIjoxNjcxMDUxODkyLCJuYmYiOjE2NzEwNDgyOTIsImp0aSI6IkwzZld4VjNDbW84VXlWNVEiLCJzdWIiOjEsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.SaZ1IATrNGQEizrQBelHDLhCKRDK2toHX6YYqE_VWqQ");//this is working
        //$request->headers->set("Authorization", "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTY3MTA0OTQ1NCwiZXhwIjoxNjcxMDUzMDU0LCJuYmYiOjE2NzEwNDk0NTQsImp0aSI6IlZOU0FKWFZ2bkZxRTAwbkMiLCJzdWIiOjEsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.4Fa-H8pyUr0xcbVvMKalkeinBwFea3-IULVzDfTHRWQ");
        $response = $next($request);
        //var_dump($response);die();
       // var_dump(session()->all());die();
        //var_dump($token);die();
        //$response->header('header name', 'header value');
        return $response;
    }
}
