<script type="text/javascript">
$(document).ready(function () {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');  // for CSRF token

    // Add form and update validation rules
    var addAndUpdateValidationOptions = {
        rules: {
            'images': {  // Corrected field name
                required: true,
                extension: "jpg|jpeg|png|gif", // Specify allowed file extensions
            },
        },
        messages: {
            'images': {  // Corrected field name
                required: "Please select images to upload.",
                extension: "Only image files (jpg, jpeg, png, gif) are allowed.",
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

    // Apply validation to the form
    $('#addForm').validate(addAndUpdateValidationOptions);

    // Function to reset form and validation errors
    function resetFormAndValidation() {
        $('#addForm')[0].reset();  // Reset the form fields
        $('#addForm').validate().resetForm();  // Reset the validation messages and states
        $('#addForm').find('.is-invalidRed').removeClass('is-invalidRed');
        $('#addForm').find('.is-validGreen').removeClass('is-validGreen');
    }

    // Clear form and validation errors when the modal is hidden
    $('#addMultiImagesModal').on('hidden.bs.modal', function () {
        resetFormAndValidation();
    });

    // Show Add Multi Images Modal
    $('#addmultiImagesButton').click(function() {
        $('#modalTitle').text('Upload Multiple Images');  // Updated title
        $('#modalButton').text('Save');
        $('#addForm')[0].reset();
        $('.text-danger').text('');  // Clear all error messages
        $('#addMultiImagesModal').modal('show');
    });

    // Submit Add/Update Form
    $('#addForm').submit(function(e) {
        e.preventDefault();

        // Validate the form before submitting
        if (!$('#addForm').valid()) {
            document.getElementsByClassName('errorSound')[0].play();  // Play sound for error
            toastr.error('Please select images to upload.', 'Error');
            return;  // Return if form is not valid
        }

        let formData = new FormData(this);
        let url = '{{ route('upload-images') }}';  // Use the correct route helper
        let type = 'post';

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
                    $('#addMultiImagesModal').modal('hide');
                    document.getElementsByClassName('successSound')[0].play();  // Play sound for success
                    toastr.success(response.message, 'Added');
                    resetFormAndValidation();
                }
            }
        });
    });

    // Clear the server-side validation errors on input change
    $('#addForm').on('input change', 'input', function() {
    var fieldName = $(this).attr('name');

    // Clear specific field error message for text, email, etc.
    $(`[name="${fieldName}"]`).next('.text-danger').html('');

    // Special handling for file inputs
    if ($(this).attr('type') === 'file') {
        $('#images_error').html(''); // Clear the file input error message
    }
});

});

</script>
