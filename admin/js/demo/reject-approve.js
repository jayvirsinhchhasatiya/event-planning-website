// =====================================================

// Approve Form
$('#dataTable').on('click', '.approve-btn', function (event) {
    event.preventDefault();

    var id = $(this).data('registration-id');

    // Disable all reject and approve buttons
    $('.reject-btn').prop('disabled', true);
    $('.approve-btn').prop('disabled', true);

    var spinner = '<div class="spinner-border me-2 text-light" role="status"></div>';
    var loadingText = '<span class="visually-hidden">Loading..</span>';

    $(this).html('<div class="d-flex align-items-center justify-content-center">' + spinner + loadingText + '</div>');

    // var spinner = '<div class="spinner-border me-2 text-light" role="status"><span class="visually-hidden">Loading...</span></div> Please Wait..';

    // .html('<div class="d-flex align-items-center justify-content-center">' + spinner + '</div>');

    $.ajax({
        url: 'approve.php',
        method: 'POST',
        data: {
            id: id,
        },
        success: function (response) {
            var startIndex = response.indexOf("success");
            if (startIndex !== -1) {
                var trimmedResponse = response.substring(startIndex);
                if (trimmedResponse === 'success') {
                    alert('Approved Successfully.');
                    window.location.reload();
                } else {
                    alert('Something went wrong 1');
                    window.location.reload();
                }
            } else {
                alert('Something went wrong 2');
                window.location.reload();
            }
        },
        complete: function () {
            // Enable all reject and approve buttons
            $('.reject-btn').prop('disabled', false);
            $('.approve-btn').prop('disabled', false).html('Approve');
        }
    });
});

// Reject Form
$('#dataTable').on('click', '.reject-btn', function (event) {
    event.preventDefault();

    var id = $(this).data('registration-id');

    // Disable all reject and approve buttons
    $('.reject-btn').prop('disabled', true);
    $('.approve-btn').prop('disabled', true);

    var spinner = '<div class="spinner-border me-2 text-light" role="status"></div>';
    var loadingText = '<span class="visually-hidden">Loading..</span>';

    $(this).html('<div class="d-flex align-items-center justify-content-center">' + spinner + loadingText + '</div>');

    $.ajax({
        url: 'reject.php',
        method: 'POST',
        data: {
            id: id,
        },
        success: function (response) {
            var startIndex = response.indexOf("success");
            if (startIndex !== -1) {
                var trimmedResponse = response.substring(startIndex);
                if (trimmedResponse === 'success') {
                    alert('Rejected Successfully.');
                    window.location.reload();
                } else {
                    alert('Something went wrong');
                    window.location.reload();
                }
            } else {
                alert('Something went wrong');
                window.location.reload();
            }
        },
        complete: function () {
            // Enable all reject and approve buttons
            $('.reject-btn').prop('disabled', false);
            $('.approve-btn').prop('disabled', false).html('Reject');
        }
    });
});



// ==========================================================
