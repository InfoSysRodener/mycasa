<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
   public function handle($request, Closure $next)
    {
        //1
        $trusted_domains = ["http://localhost:8080", "http://mycasav2-env.ftppg4fb5f.ap-southeast-1.elasticbeanstalk.com"];

        if(isset($request->server()['HTTP_ORIGIN']))
        {
            $origin = $request->server()['HTTP_ORIGIN'];

            if(in_array($origin, $trusted_domains))
            {
                header('Access-Control-Allow-Origin: '. $origin );
                header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization');
                header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS');
            }
        }

        return $next($request);

        //2
        // $headers = [
        //     'Access-Control-Allow-Origin'      => '*',
        //     'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
        //     'Access-Control-Allow-Credentials' => 'true',
        //     'Access-Control-Max-Age'           => '86400',
        //     'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With'
        // ];

        // if ($request->isMethod('OPTIONS')) {
        //     return response()->json('{"method":"OPTIONS"}', 200, $headers);
        // }

        // $response = $next($request);

        // foreach ($headers as $key => $value) {
        //     $response->header($key, $value);
        // }

        // return $response;

        //3
        // $response = $next($request);

        // $response->headers->set('Access-Control-Allow-Origin' , '*');
        // $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE, PATCH');
        // $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');

        // return $response;

        //4
        // return $next($request)
        // ->headers->set('Access-Control-Allow-Origin' , '*');
        // ->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE, PATCH');
        // ->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');

        //5
        // header("Access-Control-Allow-Origin: *");
        //ALLOW OPTIONS METHOD
        // $headers = [
        //     'Access-Control-Allow-Origin'  => '*',
        //     'Access-Control-Allow-Methods' => 'POST,GET,OPTIONS,PUT,DELETE',
        //     'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, Authorization',
        // ];

        // if ($request->getMethod() == "OPTIONS"){
        //     //The client-side application can set only headers allowed in Access-Control-Allow-Headers
        //     return response()->json('OK',200,$headers);
        // }
        // $response = $next($request);

        // foreach ($headers as $key => $value) {
        //     $response->header($key, $value);
        // }

        // return $response;

        //6
        // header('Access-Control-Allow-Origin:  *');
        // header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
        // header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

        // return $next($request);
    }
}
