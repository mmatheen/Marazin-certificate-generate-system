<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {

        if (!$request->expectsJson()) {
            // Flash an alert message to the session
            session()->flash('toastr-error', 'Your session has expired. Please log in again.');
            return route('userLogin'); // Redirect to the login route
        }

        // Check for web guard
        if ($this->auth->guard('web')->check()) {
        // Flash an alert message to the session
        session()->flash('toastr-error', 'Unauthorized access. You do not have permission to access this Page without login.');
            return $request->expectsJson() ? null : route('userLogin');
        }
        // Check for student guard
        if ($this->auth->guard('student')->check()) {
             // Flash an alert message to the session
             session()->flash('toastr-error', 'Unauthorized access. You do not have permission to access this Page without login.');
            return $request->expectsJson() ? null : route('student/login');
        }

        return $request->expectsJson() ? null : route('userLogin');
         // Flash an alert message to the session
         session()->flash('toastr-error', 'Unauthorized access. You do not have permission to access this Page without login.');

    }
}
