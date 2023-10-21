$(document).ready(function () {
    // display details in update form
    $('.update-btn').on('click', function (event) {
        event.preventDefault();

        var equipmentId = $(this).data('equipment-id');

        $.ajax({
            url: 'fetch_equipment.php',
            method: 'GET',
            data: { id: equipmentId },
            dataType: 'json',
            success: function (response) {
                if (response !== null) {
                    $('#equipment-id').val(response.id);
                    $('#nameupdate').val(response.name);
                    $('#descriptionupdate').val(response.description);
                    $('#previousimg').attr('src', response.imgpath);

                    $('#updateEquipmentModal').modal('show');
                } else {
                    alert('Equipment details not found.');
                }
            },
            error: function () {
                alert('Error occurred while fetching equipment details.');
            }
        });
    });

    // update Form
    $('#equipmentUpdateForm').submit(function (e) {
        e.preventDefault();

        // Validate form fields
        var name = $('#nameupdate').val().trim();
        var id = $('#equipment-id').val();
        // console.log(id);
        var description = $('#descriptionupdate').val().trim();
        var image = $('#imageupdate').prop('files')[0];

        // Check if fields are not empty
        if (name === '' || description === '') {
            alert('All fields are required');
            return;
        }

        // Check description word count
        var wordCount = description.split(' ').length;
        if (wordCount > 15) {
            alert('Description should be less than 15 words');
            return;
        }

        var formData = new FormData(this);
        formData.append('equipment-id', $('#equipment-id').val()); // Append the equipment ID

        if (image) {
            // Check file size (5MB limit)
            var fileSize = image.size / (1024 * 1024); // Convert to MB
            if (fileSize > 5) {
                alert('File size should be less than 5MB');
                return;
            }

            var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            var fileExtension = image.name.split('.').pop().toLowerCase();
            if (!allowedExtensions.includes(fileExtension)) {
                alert('Invalid file extension. Allowed extensions: ' + allowedExtensions.join(', '));
                return;
            }
        } else {
            formData.delete('imageupdate');
        }



        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,

            success: function (response) {
                // console.log(response);

                if (response.success === true) {
                    alert('Equipment updated successfully');
                    window.location.reload();
                } else if (response.success === false) {
                    console.log(response.message);
                } else {
                    alert('Error updating equipment');
                }


            },
            error: function (xhr, status, error) {
                console.log('Server error: ' + xhr.responseText);
            }
        });
    });

    // ========================================================================

    // var deleteForm = $('#deleteForm');
    $('#dataTable').on('click', '.delete-btn', function (event) {
        event.preventDefault();

        var id = $(this).data('delete-id');

        // Display a confirmation dialog
        var confirmation = confirm('Are you sure you want to delete this equipment?');

        if (confirmation) {
            // Confirmation is true, proceed with the delete action

            // Disable the delete button
            $('.update-btn').prop('disabled', true);
            $('.delete-btn').prop('disabled', true);

            var spinner = '<div class="spinner-border me-2 text-light" role="status"></div>';
            var loadingText = '<span class="visually-hidden">Loading..</span>';

            $('#delete-btn-' + id).html('<div class="d-flex align-items-center justify-content-center">' + spinner + loadingText + '</div>');

            // var spinner = '<div class="spinner-border me-2 text-light" role="status"><span class="visually-hidden"></span></div>Please Wait..';

            // $('#delete-btn-'+id).html('<div class="d-flex align-items-center justify-content-center">' + spinner + '</div>');

            $.ajax({
                url: 'delete_equipment.php',
                method: 'POST',
                data: {
                    equipment_id_delete: id
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success === true) {
                        // Deletion successful, perform any necessary actions
                        alert('Equipment deleted successfully');
                        window.location.reload(); // Reload the page or update the UI as needed
                    } else {
                        // Deletion failed, handle the error
                        alert('Error deleting equipment');
                    }
                },
                error: function () {
                    // Handle the server error
                    alert('Server error. Please try again later.');
                },
                complete: function () {
                    $('.update-btn').prop('disabled', false);
                    $('.delete-btn').prop('disabled', false);
                    $('#delete-btn-' + id).html('Delete');
                }
            });
        } else {
            // Confirmation is false, do nothing
            return;
        }
    });



    // ========================================================================

    // submit Form
    $('#equipmentForm').submit(function (e) {
        e.preventDefault();

        // Validate form fields
        var name = $('#name').val().trim();
        var description = $('#description').val().trim();
        var image = $('#image').prop('files')[0];

        // Check if fields are not empty
        if (name === '' || description === '' || image === undefined) {
            alert('All fields are required');
            return;
        }

        // Check description word count
        var wordCount = description.split(' ').length;
        if (wordCount > 15) {
            alert('Description should be less than 15 words');
            return;
        }

        // Check file size (5MB limit)
        var fileSize = image.size / (1024 * 1024); // Convert to MB
        if (fileSize > 5) {
            alert('File size should be less than 5MB');
            return;
        }

        var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        var fileExtension = image.name.split('.').pop().toLowerCase();
        if (!allowedExtensions.includes(fileExtension)) {
            alert('Invalid file extension. Allowed extensions: ' + allowedExtensions.join(', '));
            return;
        }

        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,

            success: function (response) {
                if (response.success) {
                    alert('Equipment added successfully');
                    window.location.reload();
                } else {
                    alert('Error adding equipment');
                }
            },
            error: function () {
                alert('Server error. Please try again later.');
            }
        });
    });
});