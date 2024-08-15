@extends('layout.layout')
@section('content')

<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Import Student</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Import Student</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body">
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="row">
                                <div class="col-md-12">
                                    {{-- add new lead import start --}}
                                    <div class="import_file color">
                                        <form class="d-flex" action="#" id="importStudentForm" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" class="form-control" name="file">
                                            <button type="submit" id="import_btn" class="btn btn-outline-primary ms-5">Upload</button>
                                            <a class="btn btn-outline-success ms-3" id="export_btn" href="{{ route('excel-export-student-list') }}">Download</a>
                                            <a class="btn btn-outline-dark ms-3" id="export_btn" href="{{ route('excel-blank-template-export') }}">Template</a>
                                        </form>
                                        <div class="progress mt-3" style="display: none;">
                                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="text-danger" id="file_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

{{-- this is ajax script coding --}}

@include('students.student_ajax')
@endsection

<style>
    .color {
        background-color: rgb(230, 233, 233);
        padding: 35px 20px 20px;
        border-radius: 8px;
    }
    #file {
        width: 80%;
    }
    .progress {
        height: 20px;
    }
    .progress-bar {
        background-color: #007bff;
        transition: width 0.4s ease;
    }
</style>


