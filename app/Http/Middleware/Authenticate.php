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


        // Check if the request is from the 'web' guard
        if ($this->auth->guard('web')->guest()) {
            session()->flash('toastr-error', 'Unauthorized access. You do not have permission to access this page without login.');
            return route('userLogin'); // Redirect to the user login route
        }

        // Check if the request is from the 'student' guard
        if ($this->auth->guard('student')->guest()) {
            session()->flash('toastr-error', 'Unauthorized access. You do not have permission to access this page without login.');
            return route('student/login'); // Redirect to the student login route
        }

        // Default redirection
        return $request->expectsJson() ? null : route('userLogin');
    }
}
