<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleBasedRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check() && auth()->user()->hasRole('SuperAdmin')) {
            return redirect()->route('companies.index');
        }
    if( auth()->check() && auth()->user()->hasRole('Admin')){
        $company = Company::find(auth()->user()->company->id);
        return redirect()->route('company.members.index',$company);
    }
    if(auth()->check() && auth()->user()->hasRole('Member')) {
        return redirect()->route('shorturls.index');
    }
        return $next($request);
    }
}
