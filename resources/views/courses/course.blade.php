@extends('layout.layout')
@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Course</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">List Course</li>
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
                                <button type="button" class="btn btn-outline-info " id="addCourseButton">
                                    New <i class="fas fa-plus px-2"> </i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="course" class="datatable table table-stripped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Course Name</th>
                                    <th>Short Name</th>
                                    <th>Actions</th>
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
        <div id="addAndEditCourseModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center mt-2 mb-4">
                            <h5 id="modalTitle"></h5>
                        </div>
                        <form id="addAndUpdateForm">

                            <div class="row">
                                <input type="hidden" name="edit_id" id="edit_id">

                                <div class="col-md-12">
                                    <div class="form-group local-forms">
                                        <label>Course Name <span class="login-danger">*</span></label>
                                        <input class="form-control" id="edit_course_name" name="course_name" placeholder="Enter Course Name">
                                        <span class="text-danger" id="course_name_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group local-forms">
                                        <label>Short Name <span class="login-danger">*</span></label>
                                        <input class="form-control" id="edit_short_name" name="short_name" placeholder="Enter Short Name">
                                        <span class="text-danger" id="short_name_error"></span>
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

@include('courses.course_ajax')
@endsection
