<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ... $roles): Response
    {
        // $isAdminValid = auth()->user()->isAdmin() && auth()->check();
        // if (!$isAdminValid) {
        //     auth()->logout();
        //     return redirect('login')
        //         ->with('login-status', 'These credentials do not match our records.');
        // }

        $allowAccess = false;
        //DD(auth()->check());
        if(auth()->check())
        {
            foreach($roles as $role) {
                if($request->user()->role->role === $role) {
                    $allowAccess = true;
                    break;
                }
            }		 
        }

        if(!$allowAccess) {
            //return redirect()->route('login');
            return redirect()->back()
                ->with('status', 'Access denied.');
        }

        return $next($request);
    }
}
