<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle(Request $request, Closure $next,$type): Response
    {
        $user=Auth::user();
        if(!$user)
          return redirect()->route('login');
        
        if($type=="all")
           return $next($request);
          
        if($user->getType()!==$type)
           abort(403,'Unauthorized:not a '.$type);
          
        // if($type==='provider' && !$user->provider)
        //   abort(403,'Unauthorized:not a provider');

        // if($type==='client' && !$user->client)
        //   abort(403,'Unauthorized:not a client');
     
        // if($type==='admin' && ($user->provider || $user->client))
        //   abort(403,'Unauthorized:not a admin');

        return $next($request);
    }
}
