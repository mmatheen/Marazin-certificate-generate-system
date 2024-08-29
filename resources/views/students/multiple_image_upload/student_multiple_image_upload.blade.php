@extends('layout.layout')
@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Multiple Images</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Multiple Images</a></li>
                            <li class="breadcrumb-item active">Multiple Images</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table row --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body">
                    <div class="import_file color">
                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col-auto text-end float-end ms-auto download-grp">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" id="addmultiImagesButton">
                                        Multiple Image Upload <i class="fas fa-plus px-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add/Edit modal row --}}
    <div class="row">
        <div id="addMultiImagesModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center mt-2 mb-4">
                            <h5 id="modalTitle">Multiple Students Images</h5>
                        </div>
                        <form id="addForm" enctype="multipart/form-data">

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="invoices-upload-btn">
                                        <input class="hide-input mb-2" id="edit_images"  name="images[]" type="file" multiple>
                                        <label for="file" class="upload">multiple pictures </label>
                                    </div>
                                     <span class="text-danger" id="images_error"></span>
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
</div>

@include('students.multiple_image_upload.student_multiple_image_upload_ajax')
@endsection




<style>
    .color {
        background-color: rgb(230, 231, 233);
        padding: 30px 20px 10px;
        border-radius: 8px;
    }

</style>
