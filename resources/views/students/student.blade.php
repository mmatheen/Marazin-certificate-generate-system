@extends('layout.layout')
@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Student</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="students.html">Student</a></li>
                            <li class="breadcrumb-item active">List Student</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- table row --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body">
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col-auto text-end float-end ms-auto download-grp">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-outline-info " id="addStudentButton">
                                    New <i class="fas fa-plus px-2"> </i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="student" class="datatable table table-stripped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Register Date</th>
                                    <th>Effective Date Of Certificate</th>
                                    <th>Registration No</th>
                                    <th>Certificate No</th>
                                    <th>Reference No</th>
                                    <th>Batch No</th>
                                    <th>Course Year</th>
                                    <th>course Name</th>
                                    <th>Full Name Of Student</th>
                                    <th>Name With Initial</th>
                                    <th>NIC No</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add/Edit modal row --}}
    <div class="row">
        <div id="addAndEditStudentModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center mt-2 mb-4">
                            <h5 id="modalTitle"></h5>
                        </div>
                        <form id="addAndUpdateForm">

                            <div class="row">
                                <input type="hidden" name="edit_id" id="edit_id">

                                <div class="col-md-6">
                                    <div class="form-group local-forms calendar-icon">
                                        <label>Registeration Date <span class="login-danger">*</span></label>
                                        <input type="text" name="register_date" id="edit_register_date" autocomplete="off" placeholder="YYYY.MM.DD" class="form-control datetimepicker me-5">
                                    </div>
                                    <span class="text-danger" id="register_date_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group local-forms calendar-icon">
                                        <label>Effective Date Of Certificate <span class="login-danger">*</span></label>
                                        <input type="text" name="effective_date_of_certificate" id="edit_effective_date_of_certificate" autocomplete="off" placeholder="YYYY.MM.DD" class="form-control datetimepicker me-5">
                                    </div>
                                    <span class="text-danger" id="effective_date_of_certificate_error"></span>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group local-forms">
                                        <label>Course Name<span class="login-danger">*</span></label>
                                        <select id="edit_course_name" name="course_name" class="form-control">
                                            <option selected disabled>Please Select Course</option>
                                            @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group local-forms">
                                        <label>Batch No <span class="login-danger">*</span></label>
                                        <select id="edit_batch_id" name="batch_id" class="form-control">
                                            <option selected disabled>Please Select Batch</option>
                                            @foreach($batches as $batch)
                                                <option>{{ $batch->batch_no }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group local-forms">
                                        <label>Year<span class="login-danger">*</span></label>
                                        <select id="edit_year" name="year" class="form-control">
                                            <option selected disabled>Please Select Year</option>
                                            @foreach($batches as $batch)
                                                <option>{{ $batch->course_year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group local-forms">
                                        <label>Full Name Of Student <span class="login-danger">*</span></label>
                                        <input class="form-control" id="edit_full_name_of_student" name="full_name_of_student" placeholder="Enter Full Name Of Student">
                                        <span class="text-danger" id="full_name_of_student_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group local-forms">
                                        <label>Name With Initial <span class="login-danger">*</span></label>
                                        <input class="form-control" id="edit_name_with_initial" name="name_with_initial" placeholder="Enter Name With Initial">
                                        <span class="text-danger" id="name_with_initial_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group local-forms">
                                        <label>NIC No <span class="login-danger"></span>*</label>
                                        <input class="form-control" id="edit_nic_no" name="nic_no" placeholder="Enter NIC No">
                                        <span class="text-danger" id="nic_no_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group local-forms">
                                        <label>Address <span class="login-danger">*</span></label>
                                        <input class="form-control" id="edit_address" name="address" placeholder="Enter Address">
                                        <span class="text-danger" id="address_error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" id="modalButton" class="btn btn-outline-primary">Save</button>
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete modal --}}
    <div id="deleteModal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3 id="deleteName"></h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <input type="hidden" id="deleting_id">
                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="confirm_delete_btn btn btn-primary paid-continue-btn" style="width: 100%;">Delete</button>
                                </div>
                                <div class="col-6">
                                    <a data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn">Cancel
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('students.student_ajax')
@endsection
