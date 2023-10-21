$(document).ready(function () {

    // Validate email
    var checkEmail;
    $('#email').on('keyup', function () {
        var email = $(this).val();
        if (email == null || email == "") {
            $('#email').addClass('is-invalid');
            $('#email-valid').addClass('invalid-feedback');
            $('#email-valid').text('Enter your email.');
            checkEmail = false;
        } else if (!email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)) {
            $('#email').addClass('is-invalid');
            $('#email-valid').addClass('invalid-feedback');
            $('#email-valid').text('Enter a valid email address.');
            checkEmail = false;
        } else {
            $.ajax({
                url: 'check_email.php',
                method: 'POST',
                data: { email: email },
                success: function (response) {
                    if (response.trim() === "true") {
                        $('#email').addClass('is-invalid');
                        $('#email-valid').addClass('invalid-feedback');
                        $('#email-valid').text('Email does not exists.');
                        checkEmail = false;
                    } else {
                        $('#email').removeClass('is-invalid');
                        $('#email-valid').removeClass('invalid-feedback');
                        $('#email-valid').text('');
                        checkEmail = true;
                    }
                }
            });
        }
    });

    var forgotPasswordForm = $('#forgotPasswordForm');
    var emailInput = $('#email');
    var resetBtn = $('[name="submit"]');


    // Form submission
    forgotPasswordForm.on('submit', function (event) {
        event.preventDefault();

        var email = $('#email').val().trim();

        if (checkEmail) {

            // Show the loader
            // $('#loader').show();
            resetBtn.prop('disabled', true);
            emailInput.prop('disabled', true);

            var spinner = '<div class="spinner-border me-2 text-light" role="status"><span class="visually-hidden">Loading...</span></div> Please Wait..';

            $('#reset-btn').html('<div class="d-flex align-items-center justify-content-center">' + spinner + '</div>');

            // Perform back-end validation
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: {
                    email: email,
                },
                success: function (response) {
                    var startIndex = response.indexOf("success");
                    if (startIndex !== -1) {
                        var trimmedResponse = response.substring(startIndex);
                        alert(trimmedResponse);
                        if (trimmedResponse === 'success') {
                            // window.location.href = "index.php";
                            alert('Password reset email sent. Check your mailbox including spam folder.');
                        } else {
                            alert('Login failed');
                        }
                    } else {
                        alert('Login failed');
                    }
                },
                complete: function () {
                    // Reset the form and remove the loader
                    forgotPasswordForm[0].reset();
                    resetBtn.prop('disabled', false);
                    emailInput.prop('disabled', false);
                    $('#reset-btn').html('Reset Password');
                }
            });
        } else {
            alert('email not found');
        }

    });

});