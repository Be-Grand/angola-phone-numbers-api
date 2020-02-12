<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e){
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['success'=>false,'message'=>'Token inválido.']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['success'=>false,'message'=>'Token expirado.']);
            }else {
                return response()->json(['success'=>false,'message'=>'Autorização não encontrada.']);
            }
        }
        if ($user->status == '1')
        return response()->json(['success'=>false,'message'=>'Conta desactivada, você já não tem permissões para operacionar.'], 401);
        else
        return $next($request);
    }
}
