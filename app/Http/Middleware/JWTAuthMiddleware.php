<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class JWTAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        //echo $request->header('Authorization');
       // echo env('JWT_SECRET',"sr");
        try {
            $token = JWTAuth::parseToken();
            $uesr_id=$token->getPayload()->get('sub');

            $request->merge(["user_id" => $uesr_id]);
        }catch (Exception $e) {


            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){


                return response()->json(['status' => 'Token is Invalid']);

            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 'Token is Expired']);
            }else{
                return response()->json(['status' => 'Authorization Token not found']);
            }}
        return $next($request);
    }

    }

