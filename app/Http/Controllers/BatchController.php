<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BatchController extends Controller
{
    public function batch(){

        $courses = Course::all();
        return view('batches.batch',compact('courses'));
    }

    public function index()
    {
         $getValue = Batch::with('course')->get();
        if ($getValue->count() > 0) {

            return response()->json([
                'status' => 200,
                'message' => $getValue
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Records Found!"
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


     public function store(Request $request)
     {
         // Custom error messages
         $messages = [
             'batch_no.required' => 'Batch number is required.',
             'batch_no.unique' => 'The Batch Number, Course, and Course Year already exists. Please Add Unique Value.',
             'course_id.required' => 'Please select a course.',
             'course_year.required' => 'Course year is required.',
         ];

         // Validate the request
         $validator = Validator::make(
             $request->all(),
             [
                 'batch_no' => [
                     'required',
                     Rule::unique('batches')->where(function ($query) use ($request) {
                         return $query->where('course_id', $request->course_id)
                                      ->where('course_year', $request->course_year);
                     }),
                 ],
                 'course_id' => 'required',
                 'course_year' => 'required',
             ],
             $messages // Pass custom messages
         );

         if ($validator->fails()) {
             return response()->json([
                 'status' => 400,
                 'errors' => $validator->messages()
             ]);
         } else {
             // Create the new batch record
             $getValue = Batch::create([
                 'batch_no' => $request->batch_no,
                 'course_id' => $request->course_id,
                 'course_year' => $request->course_year,
             ]);

             if ($getValue) {
                 return response()->json([
                     'status' => 200,
                     'message' => "New Batch Details Created Successfully!"
                 ]);
             } else {
                 return response()->json([
                     'status' => 500,
                     'message' => "Something went wrong!"
                 ]);
             }
         }
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $getValue = Batch::find($id);
        if ($getValue) {
            return response()->json([
                'status' => 200,
                'message' => $getValue
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Such Batch Found!"
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $getValue = Batch::find($id);
        if ($getValue) {
            return response()->json([
                'status' => 200,
                'message' => $getValue
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Such Batch Found!"
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'batch_no' => 'required',
                'course_id' => 'required',
                'course_year' => 'required',
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $getValue = Batch::find($id);

            if ($getValue) {
                $getValue->update([

                   'batch_no' => $request->batch_no,
                   'course_id' => $request->course_id,
                   'course_year' => $request->course_year,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Old Batch Details Updated Successfully!"
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "No Such Batch Found!"
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $getValue = Batch::find($id);
        if ($getValue) {

            $getValue->delete();
            return response()->json([
                'status' => 200,
                'message' => "Batch Details Deleted Successfully!"
            ]);
        } else {

            return response()->json([
                'status' => 404,
                'message' => "No Such Batch Found!"
            ]);
        }
    }
}
