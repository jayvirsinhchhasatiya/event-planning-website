function deleteEvent(eventId, eventDate) {
    var today = new Date();
    var eventDateObj = new Date(eventDate);

    if (eventDateObj > today) {
        var confirmDelete = confirm('Are you sure you want to delete this event?');

        if (confirmDelete) {
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
                }
            });
        }
    } else {
        alert('Cannot delete past events.');
    }
}
