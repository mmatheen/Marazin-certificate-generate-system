<script type="text/javascript">
    $(document).ready(function () {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');  //for crf token
        showFetchData();

    // add form and update validation rules code start
              var addAndUpdateValidationOptions = {
        rules: {
            course_name: {
                required: true,

            },
            short_name: {
                required: true,

            },

        },
        messages: {

            course_name: {
                required: "Course Name is required",
            },
            short_name: {
                required: "Short Name is required",
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
            $('#addAndEditCourseModal').on('hidden.bs.modal', function () {
                resetFormAndValidation();
            });

        // Show Add Warranty Modal
        $('#addCourseButton').click(function() {
            $('#modalTitle').text('New Course');
            $('#modalButton').text('Save');
            $('#addAndUpdateForm')[0].reset();
            $('.text-danger').text(''); // Clear all error messages
            $('#edit_id').val(''); // Clear the edit_id to ensure it's not considered an update
            $('#addAndEditCourseModal').modal('show');
        });

        // Fetch and Display Data
        function showFetchData() {
            $.ajax({
                url: '/course-get-all',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var table = $('#course').DataTable();
                    table.clear().draw();
                    var counter = 1;
                    response.message.forEach(function(item) {
                        let row = $('<tr>');
                        row.append('<td>' + counter  + '</td>');
                        row.append('<td>' + item.course_name + '</td>');
                        row.append('<td>' + item.short_name + '</td>');
                         row.append('<td><button type="button" value="' + item.id + '" class="edit_btn btn btn-outline-info btn-sm me-2"><i class="feather-edit text-info"></i> Edit</button><button type="button" value="' + item.id + '" class="delete_btn btn btn-outline-danger btn-sm"><i class="feather-trash-2 text-danger me-1"></i>Delete</button></td>');
                        table.row.add(row).draw(false);
                        counter++;
                    });
                },
            });
        }

            // Show Edit Modal
            $(document).on('click', '.edit_btn', function() {
            var id = $(this).val();
            $('#modalTitle').text('Edit Course');
            $('#modalButton').text('Update');
            $('#addAndUpdateForm')[0].reset();
            $('.text-danger').text('');
            $('#edit_id').val(id);

            $.ajax({
                url: 'course-edit/' + id,
                type: 'get',
                success: function(response) {
                    if (response.status == 404) {
                        toastr.error(response.message, 'Error');
                    } else if (response.status == 200) {
                        $('#edit_course_name').val(response.message.course_name);
                        $('#edit_short_name').val(response.message.short_name);
                        $('#addAndEditCourseModal').modal('show');
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
                   toastr.error('Invalid inputs, Check & try again!!','Error');
                return; // Return if form is not valid
            }

            let formData = new FormData(this);
            let id = $('#edit_id').val(); // for edit
            let url = id ? 'course-update/' + id : 'course-store';
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
                        $('#addAndEditCourseModal').modal('hide');
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
            $('#deleteName').text('Delete Course');
        });

        $(document).on('click', '.confirm_delete_btn', function() {
            var id = $('#deleting_id').val();
            $.ajax({
                url: 'course-delete/' + id,
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
    });
</script>
