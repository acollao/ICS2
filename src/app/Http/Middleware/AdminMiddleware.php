<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        $isAdminValid = auth()->user()->role_id === 1;
       
        if(! $isAdminValid) {
            //auth()->logout();
            return redirect()->back()
                ->with('status', 'Access denied.');
        }
        
        foreach($roles as $role) {
            // Check if user has the role This check will depend on how your roles are set up
            if(auth()->user()->hasrole($role))
                return $next($request);
        }


        return $next($request);
    }
}
