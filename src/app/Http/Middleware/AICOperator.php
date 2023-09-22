<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AICOperator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isAICOperator = auth()->user()->role_id === 6;
       
        if(! $isAICOperator) {
            //auth()->logout();
            return redirect()->back()
                ->with('status', 'Access denied.');
        }
        
        return $next($request);
    }
}
