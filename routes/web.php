<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Models\Course;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/testing', function () {
    // return view('welcome');

    $student = Course::find(2); // Replace 1 with a valid student ID
    if ($student) {
        dd($student->short_name); // Correct method name to match the relationship
    } else {
        dd('Student not found');
    }

});

//this is call error page
Route::fallback(function () {
    return view('ErrorPage404.404errorpage');
});

function set_active($route)
{

    if (is_array($route)) {
        return in_array(Request::path(), $route) ? 'active' : '';
    }

    return Request::path() == $route ? 'active' : '';
}


// without login you can't go to any page
Route::middleware(['auth:student'])->group(function () {

    Route::get('generate-pdf', [StudentController::class, 'generatePDF'])->name('certificate-pdf');
    Route::get('/student-certificate', [StudentController::class, 'studentCertificate'])->name('student-certificate');
});

// without login you can't go to any page and

Route::middleware(['auth:web','auth.session'])->group(function () {

    // Routes accessible to both admin and SuperAdmin
    Route::middleware(['RoleType:Admin,Super Admin'])->group(function () {

        // Student routes
        Route::get('/student', [StudentController::class, 'student'])->name('student');
        Route::get('/student-edit/{id}', [StudentController::class, 'edit']);
        Route::get('/student-get-all', [StudentController::class, 'index']);
        Route::post('/student-store', [StudentController::class, 'store']);
        Route::post('/student-update/{id}', [StudentController::class, 'update']);
        Route::delete('/student-delete/{id}', [StudentController::class, 'destroy']);

        Route::get('/batch-get-by-courseName/{course_id}', [StudentController::class, 'showBatchDetailsUsingByCourseId'])->name('batch-get-by-courseName');
        Route::get('/batch-get-by-batch-no/{batch_id}', [StudentController::class, 'showBatchDetailsUsingByBatchId'])->name('batch-get-by-batch-no');

        // Student multiple image upload routes
        Route::get('/multiple-image', [StudentController::class, 'studentMultipleImageUpload'])->name('multiple-image');
        Route::post('/upload-images', [StudentController::class, 'uploadImages'])->name('upload-images');

        // Batch routes
        Route::get('/batch', [BatchController::class, 'batch'])->name('batch');
        Route::get('/batch-edit/{id}', [BatchController::class, 'edit']);
        Route::get('/batch-get-all', [BatchController::class, 'index']);
        Route::post('/batch-store', [BatchController::class, 'store']);
        Route::post('/batch-update/{id}', [BatchController::class, 'update']);
        Route::delete('/batch-delete/{id}', [BatchController::class, 'destroy']);

        // Course routes
        Route::get('/course', [CourseController::class, 'course'])->name('course');
        Route::get('/course-edit/{id}', [CourseController::class, 'edit']);
        Route::get('/course-get-all', [CourseController::class, 'index']);
        Route::post('/course-store', [CourseController::class, 'store']);
        Route::post('/course-update/{id}', [CourseController::class, 'update']);
        Route::delete('/course-delete/{id}', [CourseController::class, 'destroy']);

        // Excel import/export routes
        Route::get('/excel-import-page-view', [StudentController::class, 'importStudentPage'])->name('excel-import-page-view');
        Route::get('/excel-export-student-list', [StudentController::class, 'export'])->name('excel-export-student-list');
        Route::get('/excel-blank-template-export', [StudentController::class, 'exportBlankTemplate'])->name('excel-blank-template-export');
        Route::post('/import-student-store', [StudentController::class, 'importStudentStore']);
    });

        // Routes only for admin and Super Admin
        Route::middleware(['auth:web', 'RoleType:Admin,Super Admin'])->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('admin-dashboard');
    });
});

// without logout you can't go to login page
Route::middleware(['guest:web','auth.session'])->group(function () {

    Route::get('/user-login', [AuthenticationController::class, 'userLogin'])->name('userLogin');
});

// without logout you can't go to student login page
Route::middleware(['guest:student'])->group(function () {

    Route::get('/', [AuthenticationController::class, 'studentLogin'])->name('student/login');
});

Route::post('/user/login', [AuthenticationController::class, 'userLoginCheck'])->name('user/login');
Route::get('/user/logout', [AuthenticationController::class, 'userLogout'])->name('user/logout');

Route::post('/student/login/check', [AuthenticationController::class, 'studentLoginCheck'])->name('student/login/check');
Route::get('/student/logout', [AuthenticationController::class, 'studentLogout'])->name('student/logout');
