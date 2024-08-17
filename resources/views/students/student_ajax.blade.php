<script type="text/javascript">
    $(document).ready(function () {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');  //for crf token
        showFetchData();

    // add form and update validation rules code start
              var addAndUpdateValidationOptions = {
        rules: {
            register_date: {
                required: true,

            },

            effective_date_of_certificate: {
                required: true,

            },
            year: {
                required: true,

            },
            course_name: {
                required: true,

            },
            registration_no: {
                required: true,

            },
            name_with_initial: {
                required: true,

            },
            reference_no: {
                required: true,

            },
            certificate_no: {
                required: true,

            },
            batch_id: {
                required: true,

            },
            full_name_of_student: {
                required: true,

            },
            nic_no: {
                required: true,

            },
            address: {
                required: true,

            },
        },
        messages: {

            register_date: {
                required: "Registration Date is required",
            },

            effective_date_of_certificate: {
                required: "Effective Date Of Certificate is required",
            },
            year: {
                required: "Year is required",
            },
            course_name: {
                required: "Course Name is required",
            },
            registration_no: {
                required: "Registration No is required",
            },
            reference_no: {
                required: "Reference No is required",
            },
            certificate_no: {
                required: "Certificate No  is required",
            },
            name_with_initial: {
                required: "Name With Initial is required",
            },
            batch_id: {
                required: "Batch No is required",
            },
            full_name_of_student: {
                required: "Full Name Of Student is required",
            },
            nic_no: {
                required: "NIC No is required",
            },
            address: {
                required: "Address is required",
            },

        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('text-danger');
            error.insertAfter(element);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalidRed').removeClass('is-validGreen');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalidRed').addClass('is-validGreen');
        },
        // Temporarily disable calendar during validation
        onfocusin: function(element) {
        if ($(element).hasClass('datetimepicker')) {
            $(element).datetimepicker('hide');
            $(element).val('');  // Clear the value when the field gains focus
        }
        this.lastActive = element;
        $(element).valid();
    }

    };

    // Apply validation to both forms
    $('#addAndUpdateForm').validate(addAndUpdateValidationOptions);

  // add form and update validation rules code end

  // Function to reset form and validation errors
        function resetFormAndValidation() {
            // Reset the form fields
            $('#addAndUpdateForm')[0].reset();
            // Reset the validation messages and states
            $('#addAndUpdateForm').validate().resetForm();
            $('#addAndUpdateForm').find('.is-invalidRed').removeClass('is-invalidRed');
            $('#addAndUpdateForm').find('.is-validGreen').removeClass('is-validGreen');
        }

        // Clear form and validation errors when the modal is hidden
            $('#addAndEditStudentModal').on('hidden.bs.modal', function () {
                resetFormAndValidation();
            });

        // Show Add Warranty Modal
        $('#addStudentButton').click(function() {
            $('#modalTitle').text('New Student');
            $('#modalButton').text('Save');
            $('#addAndUpdateForm')[0].reset();
            $('.text-danger').text(''); // Clear all error messages
            $('#edit_id').val(''); // Clear the edit_id to ensure it's not considered an update
            $('#addAndEditStudentModal').modal('show');
        });

        // Fetch and Display Data
        function showFetchData() {
                $.ajax({
                    url: '/student-get-all',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var table = $('#student').DataTable();
                        table.clear().draw();
                        var counter = 1;
                        response.message.forEach(function(item) {
                                let row = $('<tr>');
                                row.append('<td>' + counter  + '</td>');
                                row.append('<td>' + item.register_date + '</td>');
                                row.append('<td>' + item.effective_date_of_certificate + '</td>');
                                row.append('<td>' + item.registration_no + '</td>');
                                row.append('<td>' + item.certificate_no + '</td>');
                                row.append('<td>' + item.reference_no + '</td>');
                                row.append('<td>' + item.batch.batch_no + '</td>');
                                row.append('<td>' + item.batch.course_year + '</td>');
                                row.append('<td>' + item.batch.course.course_name + '</td>');
                                row.append('<td>' + item.full_name_of_student + '</td>');
                                row.append('<td>' + item.name_with_initial + '</td>');
                                row.append('<td>' + item.nic_no + '</td>');
                                row.append('<td>' + item.address + '</td>');
                                row.append('<td><button type="button" value="' + item.id + '" class="edit_btn btn btn-outline-info btn-sm me-2"><i class="feather-edit text-info"></i> Edit</button><button type="button" value="' + item.id + '" class="delete_btn btn btn-outline-danger btn-sm"><i class="feather-trash-2 text-danger me-1"></i> Delete</button></td>');
                                table.row.add(row).draw(false);
                                counter++;
                        });
                    },
                });
            }



            // Show Edit Modal
            $(document).on('click', '.edit_btn', function() {
            var id = $(this).val();
            $('#modalTitle').text('Edit Student');
            $('#modalButton').text('Update');
            $('#addAndUpdateForm')[0].reset();
            $('.text-danger').text('');
            $('#edit_id').val(id);

            $.ajax({
                url: 'student-edit/' + id,
                type: 'get',
                success: function(response) {
                    if (response.status == 404) {
                        toastr.error(response.message, 'Error');
                    } else if (response.status == 200) {
                        $('#edit_register_date').val(response.message.register_date);
                        $('#edit_effective_date_of_certificate').val(response.message.effective_date_of_certificate);
                        $('#edit_full_name_of_student').val(response.message.full_name_of_student);
                        $('#edit_name_with_initial').val(response.message.name_with_initial);
                        $('#edit_nic_no').val(response.message.nic_no);
                        $('#edit_course_name').val(response.message.course_name);
                        $('#edit_batch_id').val(response.message.batch.batch_no);
                        $('#edit_year').val(response.message.batch.course_year);
                        $('#edit_address').val(response.message.address);
                        $('#addAndEditStudentModal').modal('show');
                    }
                }
            });
        });


        // Submit Add/Update Form
        $('#addAndUpdateForm').submit(function(e) {
            e.preventDefault();

             // Validate the form before submitting
            if (!$('#addAndUpdateForm').valid()) {
                   document.getElementsByClassName('errorSound')[0].play(); //for sound
                   toastr.error('Please fill in all the required fields.','Error');
                return; // Return if form is not valid
            }

            let formData = new FormData(this);
            let id = $('#edit_id').val(); // for edit
            let url = id ? 'student-update/' + id : 'student-store';
            let type = id ? 'post' : 'post';

            $.ajax({
                url: url,
                type: type,
                headers: {'X-CSRF-TOKEN': csrfToken},
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.errors, function(key, err_value) {
                             $('#' + key + '_error').html(err_value);
                            document.getElementsByClassName('errorSound')[0].play(); //for sound
                            toastr.error(err_value,'Error');
                        });

                    } else {
                        $('#addAndEditStudentModal').modal('hide');
                           // Clear validation error messages
                        showFetchData();
                        document.getElementsByClassName('successSound')[0].play(); //for sound
                        toastr.success(response.message, id ? 'Updated' : 'Added');
                        resetFormAndValidation();
                    }
                }
            });
        });

        // it will Clear the serverside validation errors on input change
        // Clear validation error for specific fields on input change based on 'name' attribute
        $('#addAndUpdateForm').on('input change', 'input', function() {
            var fieldName = $(this).attr('name');
            $('#' + fieldName + '_error').html(''); // Clear specific field error message
        });



        // Delete Warranty
        $(document).on('click', '.delete_btn', function() {
            var id = $(this).val();
            $('#deleteModal').modal('show');
            $('#deleting_id').val(id);
            $('#deleteName').text('Delete Student');
        });

        $(document).on('click', '.confirm_delete_btn', function() {
            var id = $('#deleting_id').val();
            console.log(id);
            $.ajax({
                url: 'student-delete/' + id,
                type: 'delete',
                headers: {'X-CSRF-TOKEN': csrfToken},
                success: function(response) {
                    if (response.status == 404) {
                        toastr.error(response.message, 'Error');
                    } else {
                        $('#deleteModal').modal('hide');
                        showFetchData();
                        document.getElementsByClassName('successSound')[0].play(); //for sound
                        toastr.success(response.message, 'Deleted');
                    }
                }
            });
        });


         // Disable the batch_no dropdown Before course_name is selected
        //  $('#edit_batch_id').prop('disabled', true);
        //  $('#edit_year').prop('disabled', true);

     // Get value of courseName
        $('#edit_course_name').change(function() {
            var course_id = $(this).val();
            console.log(course_id);

            // Clear and reset the batch_no dropdown
            $('#edit_batch_id').empty().append('<option selected disabled>Please Select Batch</option>');
            $('#edit_year').empty().append('<option selected disabled>Please Select Year</option>'); // Keep year dropdown disabled and clear options

            $.ajax({
                url: 'batch-get-by-courseName/' + course_id,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        // Populate the batch_no options
                        response.message.forEach(function(batch) {
                            // Enable the option but leave the dropdown enabled
                            $('#edit_batch_id').append('<option value="' + batch.id + '">' + batch.batch_no + '</option>');
                        });

                        // Enable the batch_no dropdown after course_name is selected
                        // $('#edit_batch_id').prop('disabled', false);
                    } else {
                        console.log('Error: ', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error: ', error);
                }
            });
        });

        // Get value of batch_no
        $('#edit_batch_id').change(function() {
            var batch_id = $(this).val();
            console.log(batch_id);

            // Clear and reset the year dropdown
            $('#edit_year').empty().append('<option selected disabled>Please Select Year</option>');

            $.ajax({
                url: 'batch-get-by-batch-no/' + batch_id,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        // Populate the year options
                        response.message.forEach(function(batch) {
                            // Enable the option but leave the dropdown enabled
                            $('#edit_year').append('<option value="' + batch.course_year + '">' + batch.course_year + '</option>');
                        });

                        // Enable the year dropdown after batch_no is selected
                        // $('#edit_year').prop('disabled', false);
                    } else {
                        console.log('Error: ', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error: ', error);
                }
            });
        });




    });
</script>


{{-- impoprt lead file code start --}}
<script>
    $(document).on('submit', '#importStudentForm', function(e) {
        e.preventDefault();
        let formData = new FormData($('#importStudentForm')[0]);
        let fileInput = $('input[name="file"]')[0];

        // Check if a file is selected
        if (fileInput.files.length === 0) {
            $('#file_error').html('Please select the excel format file.');
            document.getElementsByClassName('errorSound')[0].play(); //for sound
            toastr.error('Please select the excel format file' ,'Error');
            return;
        } else {
            $('#file_error').html('');
        }

        $.ajax({
            xhr: function() {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        let percentComplete = e.loaded / e.total * 100;
                        $('.progress').show();
                        $('.progress-bar').css('width', percentComplete + '%');
                        $('.progress-bar').attr('aria-valuenow', percentComplete);
                        $('.progress-bar').text(Math.round(percentComplete) + '%'); // Display the percentage
                    }
                }, false);
                return xhr;
            },
            url: 'import-student-store',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function() {
                $('.progress-bar').css('width', '0%').text('0%');
                $('.progress').show();
            },
            success: function(response) {
                if (response.status == 400) {
                    $.each(response.errors, function(key, err_value) {
                        $('#' + key + '_error').html(err_value); // Assuming there's only one file input with id 'leadFile'
                        document.getElementsByClassName('errorSound')[0].play(); //for sound
                        toastr.error(err_value,'Error');

                    });
                    $('.progress').hide(); // Hide progress bar on validation error
                } else if (response.status == 200) {
                    $("#importStudentForm")[0].reset();
                    document.getElementsByClassName('successSound')[0].play(); //for sound
                        toastr.success(response.message, 'Uploaded');
                    $('.progress').hide();
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                document.getElementsByClassName('errorSound')[0].play(); //for sound
                toastr.error('An error occurred while processing the request.');
                $('.progress').hide(); // Hide progress bar on request error
            },
            complete: function() {
                $("#importStudentForm")[0].reset();
                $('.progress').hide(); // Ensure progress bar is hidden after completion
            }
        });
    });
</script>
