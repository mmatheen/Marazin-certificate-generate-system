<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Student;

class UserController extends Controller
{
    public function dashboard()
    {

        $data=[];

        $data['TotalCoursesCount'] = Course::count();
        $data['TotalStudentsCount'] = Student::count();
        $data['TotalBatchesCount'] = Batch::count();

        return view('includes.dashboards.dashboard', $data);
    }



}
