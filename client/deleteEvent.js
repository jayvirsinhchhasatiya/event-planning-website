function deleteEvent(eventId, eventDate) {
    var today = new Date();
    var eventDateObj = new Date(eventDate);

    if (eventDateObj > today) {
        var confirmDelete = confirm('Are you sure you want to delete this event?');

        if (confirmDelete) {
            // alert(eventId);
             // Disable the delete button
             $('.show-btn').prop('disabled', true);
             $('.update-btn').prop('disabled', true);
             $('.delete-btn').prop('disabled', true);

             var spinner = '<div class="spinner-border me-2 text-light" role="status"></div>';
             var loadingText = '<span class="visually-hidden">Loading..</span>';

            $('#delete-btn-' + eventId).html('<div class="d-flex align-items-center justify-content-center">' + spinner + loadingText + '</div>');

            $.ajax({
                url: 'deleteEvent.php',
                method: 'POST',
                data: { eventId: eventId },
                dataType: 'json',
                success: function (response) {
                    console.log(response); // Log the entire response for debugging
                    if (response.success) {
                        alert('Event deleted successfully.');
                        // Reload the page or update the event list as needed
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function () {
                    alert('Error deleting event.');
                },
                complete: function () {
                    $('.show-btn').prop('disabled', false);
                    $('.update-btn').prop('disabled', false);
                    $('.delete-btn').prop('disabled', false);
                    $('#delete-btn-' + eventId).html('Delete');
                    
                }
            });
        }
    } else {
        alert('Cannot delete past events.');
    }
}
