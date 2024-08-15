<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class RoleTypeMiddileware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::guard('web')->user();

        if (!$user || !in_array($user->roleType, $roles)) {
             // Flash an alert message to the session
             session()->flash('toastr-error', 'Unauthorized access. You do not have permission to access this Page.');
             
             return redirect()->route('admin-dashboard');
        }

        return $next($request);
    }
}
