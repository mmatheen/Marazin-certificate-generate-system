<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{

    // user
    public function userLogin()
    {
        return view('authentication.user_login');
    }

    public function userLoginCheck(Request $request)
    {
        // Validate the user input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // If validation fails, redirect back with error messages and input data
        if ($validator->fails()) {
            return redirect()->route('user/login')->withErrors($validator)->withInput()->with('toastr-error', 'Username and password are required!');
        }

        // Attempt to authenticate the user
        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $userName = $user->name;

            switch ($user->roleType) {
                case 'Super Admin':
                    return redirect()->route('super_admin_dashboard')
                        ->with('toastr-success', 'Welcome back, Super Admin! ' . $userName);

                case 'Admin':
                    return redirect()->route('admin-dashboard')
                        ->with('toastr-success', 'Welcome back Admin! ' . $userName);

                default:
                    return redirect('/')->with('toastr-error', 'Unknown user role.');
            }
        } else {
            // Add Toastr notification for login failure
            return redirect('/')->with('toastr-error', 'Username and password do not match!');
        }
    }

    public function userLogout()
    {
        auth()->guard('web')->logout();
        return redirect('/')->with('toastr-success', 'Logout Successfully!');
    }


// student

    public function studentLogin()
    {
        return view('authentication.student_login');
    }

    public function studentLoginCheck(Request $request)
    {
        // Validate the user input
        $validator = Validator::make($request->all(), [
            'nic_no' => 'required',
            'registration_no' => 'required',
        ]);

        // If validation fails, redirect back with error messages and input data
        if ($validator->fails()) {
            return redirect()->route('student/login')->withErrors($validator)->withInput()->with('toastr-error', 'NIC and Registration No are required!');
        }

        // Manually authenticate the student without a password
        $student = Student::where('nic_no', $request->nic_no)
            ->where('registration_no', $request->registration_no)
            ->first();

        if ($student) {
            Auth::guard('student')->login($student);

            $userName = $student->full_name_of_student;

            return redirect()->route('student-certificate')
                ->with('toastr-success', 'You Logged in Successfully! ' . $userName);
        } else {
            return redirect('student-login')->with('toastr-error', 'NIC and Registration No do not match!');
        }
    }


    public function studentLogout()
    {
        auth()->guard('student')->logout();
        return redirect('student-login')->with('toastr-success', 'Logout Successfully!');
    }
}


