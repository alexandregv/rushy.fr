<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class AdminLogin
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
        if(Session::has('admin'))
          return $next($request);
        else 
          return redirect()->route('admin.login');
    }
}
