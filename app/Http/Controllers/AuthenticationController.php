<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

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
            return redirect()->route('userLogin')->withErrors($validator)->withInput()->with('toastr-error', 'Username and password are required!');
        }

        // Attempt to authenticate the user
        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Check if user is already logged in on another device
            // if ($user->session_id && $user->session_id !== Session::getId()) {
            //     auth()->guard('web')->logout();

            //     return redirect()->route('userLogin')->with('toastr-error', 'Your account is already logged in on another device.');
            // }

            // // Store the current session ID
            // if ($user && $user instanceof \App\Models\User) {
            //     $user->session_id = Session::getId();
            //     $user->save();
            // }

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
        $user = Auth::guard('web')->user(); // Retrieve the authenticated user
        if ($user && $user instanceof \App\Models\User) {
            $user->session_id = null; // Clear the session ID
            $user->save();
        }
        auth()->guard('web')->logout();
        Session::invalidate(); // Invalidate the session
        return redirect('/user-login')->with('toastr-success', 'Logout Successfully!');
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
            'certificate_no' => 'required',
        ]);

        // If validation fails, redirect back with error messages and input data
        if ($validator->fails()) {
            return redirect()->route('student/login')->withErrors($validator)->withInput()->with('toastr-error', 'NIC and Registration No are required!');
        }


        // Manually authenticate the student without a password
        $student = Student::where('nic_no', $request->nic_no)
            ->where('certificate_no', $request->certificate_no)
            ->first();

        if ($student) {
            Auth::guard('student')->login($student);

            // Check if user is already logged in on another device
            // if ($student->session_id && $student->session_id !== Session::getId()) {
            //     auth()->guard('web')->logout();

            //     return redirect()->route('userLogin')->with('toastr-error', 'Your account is already logged in on another device.');
            // }

            // // Store the current session ID
            // if ($student && $student instanceof \App\Models\Student) {
            //     $student->session_id = Session::getId();
            //     $student->save();
            // }
            $userName = $student->full_name_of_student;

            return redirect()->route('student-certificate')
                ->with('toastr-success', 'You Logged in Successfully! ' . $userName);
        } else {
            return redirect('/')->with('toastr-error', 'NIC and Certificate No do not match!');
        }
    }


    public function studentLogout()
    {
        $student = Auth::guard('student')->user(); // Retrieve the authenticated student
        if ($student && $student instanceof \App\Models\Student) {
            $student->session_id = null; // Clear the session ID
            $student->save();
        }
        auth()->guard('web')->logout();
        Session::invalidate(); // Invalidate the session
        return redirect('/')->with('toastr-success', 'Logout Successfully!');
    }

}
