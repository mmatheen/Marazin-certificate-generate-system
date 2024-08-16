<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('includes.dashboards.dashboard');
    }



}
