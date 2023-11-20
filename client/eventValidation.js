$(document).ready(function () {

    var isValid = false;
    // Validate event name
    $('#eventName').on('keyup', function () {
        var eventName = $(this).val();
        if (eventName == null || eventName == "") {
            $('#eventName').addClass('is-invalid');
            $('#eventName-valid').addClass('invalid-feedback');
            $('#eventName-valid').text('Enter the event name.');
            isValid = false;
        } else {
            $('#eventName').removeClass('is-invalid');
            $('#eventName-valid').removeClass('invalid-feedback');
            $('#eventName').addClass('is-valid');
            $('#eventName-valid').addClass('valid-feedback');
            $('#eventName-valid').text('Looks good!');
            isValid = true;
        }
    });

    // Validate event type
    var eventTypeValid = false;
    $('#eventType').on('change', function () {
        var eventType = $(this).val();
        if (eventType === "Default") {
            $('#eventType').addClass('is-invalid');
            $('#eventType-valid').addClass('invalid-feedback');
            $('#eventType-valid').text('Select a valid event type.');
            eventTypeValid = false;
        } else {
            $('#eventType').removeClass('is-invalid');
            $('#eventType-valid').removeClass('invalid-feedback');
            $('#eventType').addClass('is-valid');
            $('#eventType-valid').addClass('valid-feedback');
            $('#eventType-valid').text('Looks good!');
            eventTypeValid = true;
        }
    });


    // Validate event description
    $('#eventDescription').on('keyup', function () {
        var eventDescription = $(this).val();
        if (eventDescription == null || eventDescription == "") {
            $('#eventDescription').addClass('is-invalid');
            $('#eventDescription-valid').addClass('invalid-feedback');
            $('#eventDescription-valid').text('Enter the event description.');
            isValid = false;
        } else {
            $('#eventDescription').removeClass('is-invalid');
            $('#eventDescription-valid').removeClass('invalid-feedback');
            $('#eventDescription').addClass('is-valid');
            $('#eventDescription-valid').addClass('valid-feedback');
            $('#eventDescription-valid').text('Looks good!');
            isValid = true;
        }
    });

    // Validate event date
    $('#eventDate').on('change', function () {
        var eventDate = $(this).val();
        var today = new Date();
        var nextYear = new Date();
        nextYear.setFullYear(nextYear.getFullYear() + 1);
        var selectedDate = new Date(eventDate);

        if (selectedDate <= today || selectedDate > nextYear) {
            $('#eventDate').addClass('is-invalid');
            $('#eventDate-valid').addClass('invalid-feedback');
            $('#eventDate-valid').text('Event date must be between tomorrow and the next year.');
            isValid = false;
        } else {
            $('#eventDate').removeClass('is-invalid');
            $('#eventDate-valid').removeClass('invalid-feedback');
            $('#eventDate').addClass('is-valid');
            $('#eventDate-valid').addClass('valid-feedback');
            $('#eventDate-valid').text('Looks good!');
            isValid = true;
        }
    });


    // Validate event time
    $('#eventTime').on('input', function () {
        var eventTime = $(this).val();
        if (eventTime == null || eventTime === "") {
            $('#eventTime').addClass('is-invalid');
            $('#eventTime-valid').addClass('invalid-feedback');
            $('#eventTime-valid').text('Enter the event time.');
            isValid = false;
        } else {
            $('#eventTime').removeClass('is-invalid');
            $('#eventTime-valid').removeClass('invalid-feedback');
            $('#eventTime').addClass('is-valid');
            $('#eventTime-valid').addClass('valid-feedback');
            $('#eventTime-valid').text('Looks good!');
            isValid = true;
        }
    });


    // Validate venue
    $('#venue').on('keyup', function () {
        var venue = $(this).val();
        if (venue == null || venue == "") {
            $('#venue').addClass('is-invalid');
            $('#venue-valid').addClass('invalid-feedback');
            $('#venue-valid').text('Enter the venue.');
            isValid = false;
        } else {
            $('#venue').removeClass('is-invalid');
            $('#venue-valid').removeClass('invalid-feedback');
            $('#venue').addClass('is-valid');
            $('#venue-valid').addClass('valid-feedback');
            $('#venue-valid').text('Looks good!');
            isValid = true;

        }
    });

    // Validate task description and assignee
    $('#tasks-container').on('keyup', '.task-description, .assignee-emails', function () {
        var taskDescription = $(this).closest('.task-pair').find('.task-description').val();
        var assigneeEmails = $(this).closest('.task-pair').find('.assignee-emails').val();

        // Check if task description is empty
        if (!taskDescription.trim()) {
            $(this).closest('.task-pair').find('.task-description').addClass('is-invalid');
        } else {
            $(this).closest('.task-pair').find('.task-description').removeClass('is-invalid');
        }

        // Check if assignee emails are valid
        var invalidAssignees = assigneeEmails.split(',').filter(function (email) {
            return !isValidEmail(email.trim());
        });

        if (invalidAssignees.length > 0) {
            $(this).closest('.task-pair').find('.assignee-emails').addClass('is-invalid');
        } else {
            $(this).closest('.task-pair').find('.assignee-emails').removeClass('is-invalid');
        }
    });

    // Function to validate email address
    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Add task
    $('#addTask').on('click', function () {
        // Check if the last task and assignee pair is filled before adding a new one
        var lastTaskPair = $('.task-pair').last();
        var lastTaskDescription = lastTaskPair.find('.task-description').val();
        var lastAssigneeEmails = lastTaskPair.find('.assignee-emails').val();

        if (lastTaskDescription || lastAssigneeEmails) {
            var taskCount = $('.task-pair').length + 1;

            var newTaskPair = $('<div class="task-pair"></div>');
            var task = $('<div class="task"></div>').html(`
                <label for="task_description_${taskCount}" class="form-label">Task Description</label>
                <input type="text" class="form-control task-description" name="tasks[${taskCount}][description]" placeholder="Enter task description">
            `);
            var assignee = $('<div class="assignee"></div>').html(`
                <label for="assignees_${taskCount}" class="form-label mt-2">Assignees (comma-separated emails)</label>
                <input type="text" class="form-control assignee-emails" name="tasks[${taskCount}][assignees]" placeholder="Enter assignee emails">
            `);

            newTaskPair.append(task, assignee);
            $('#tasks-container').append(newTaskPair);
        } else {
            // Display an alert if the last task and assignee pair is empty
            alert('Please fill in the last task and assignee pair before adding a new one.');
        }
    });


    // Form submission
    var eventForm = $('#eventForm');
    eventForm.on('submit', function (event) {
        // $('#eventDate').on('change', function () {
        //     var eventDate = $(this).val();
        console.log($('#eventType').val());
        if (!isValid) {
            event.preventDefault(); // Prevent the default form submission

            // Perform all validations here before submitting the form

            // If validations pass, continue with form submission
            if (eventTypeValid) {
                var form = $(this);
                var formData = form.serialize();

                // Send form data to backend
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: formData,
                    success: function (response) {
                        // Handle the response from the server
                        // console.log(response);

                        // Check if the response indicates success
                        if (response === 'success') {
                            // Show alert for successful event creation
                            alert('Event created successfully!');

                            // Reset the form
                            eventForm[0].reset();
                        } else {
                            // Handle other responses or errors
                            alert('Error: ' + response);
                        }
                    },
                    error: function (xhr, status, error) {
                        // Handle AJAX errors
                        alert('AJAX Error: ' + error);
                    },
                    complete: function () {
                        eventForm[0].reset();
                    }
                });
            }
        }
    });

});
