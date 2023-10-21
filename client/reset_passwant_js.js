$(document).ready(function () {

    // Validate password
    $('#password').on('keyup', function () {
        var password = $('#password').val().trim();
        if (password == null || password == "") {
            $('#password').addClass('is-invalid');
            $('#password-valid').addClass('invalid-feedback');
            $('#password-valid').text('Enter password.');
        } else if (password.length <= 4) {
            $('#password').addClass('is-invalid');
            $('#password-valid').addClass('invalid-feedback');
            $('#password-valid').text('Password should contain atleast 5 charecters.');
        } else {
            $('#password').removeClass('is-invalid');
            $('#password-valid').removeClass('invalid-feedback');
            $('#password').addClass('is-valid');
            $('#password-valid').addClass('valid-feedback');
            $('#password-valid').text('Looks good!');
        }
    });

    // Validate confirm password
    var validPass;
    $('#cpassword').on('keyup', function () {
        var password = $('#password').val().trim();
        var cpassword = $(this).val().trim();
        if (password !== cpassword) {
            $('#cpassword').addClass('is-invalid');
            $('#cpassword-valid').addClass('invalid-feedback');
            $('#cpassword-valid').text('Passwords do not match.');
            validPass = false;
        } else {
            $('#cpassword').removeClass('is-invalid');
            $('#cpassword-valid').removeClass('invalid-feedback');
            $('#cpassword').addClass('is-valid');
            $('#cpassword-valid').addClass('valid-feedback');
            $('#cpassword-valid').text('Password matched.');
            validPass = true;
        }
    });

    var resetPasswordForm = $('#resetPasswordForm');
    var passwordInp = $('#password');
    var cpasswordInp = $('#cpassword');
    var resetBtn = $('[name="submit"]');

    // Form submission
    resetPasswordForm.on('submit', function (event) {
        event.preventDefault();

        if (validPass) {

            var token = $('#token').val();
            var password = $('#password').val().trim();

            passwordInp.prop('disabled', true);
            cpasswordInp.prop('disabled', true);
            resetBtn.prop('disabled', true);

            var spinner = '<div class="spinner-border me-2 text-light" role="status"><span class="visually-hidden">Loading...</span></div> Please Wait..';

            $('#reset-btn').html('<div class="d-flex align-items-center justify-content-center">' + spinner + '</div>');


            // Send form data to backend
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: {
                    token: token,
                    password: password,
                },
                success: function (response) {
                    var response = response.trim();
                    console.log(response);
                    if (response === 'success') {
                        alert("Password Updated Successfully.")
                        window.location.href = "login.php";
                    } else if (response === 'token_error') {
                        alert("Link expire.\n Generate new link.")
                        window.location.href = "forgot_password.php";
                    } else {
                        alert("Try again later..")
                    }
                },
                error: function () {
                    alert('An error occurred. Please try again.');
                },
                complete: function () {
                    // Reset the form and remove the loader
                    resetPasswordForm[0].reset();
                    passwordInp.prop('disabled', false);
                    cpasswordInp.prop('disabled', false);
                    resetBtn.prop('disabled', false);
                    $('#password').removeClass('is-valid');
                    $('#password-valid').removeClass('valid-feedback');
                    $('#password-valid').text('');
                    $('#cpassword').removeClass('is-valid');
                    $('#cpassword-valid').removeClass('valid-feedback');
                    $('#cpassword-valid').text('');
                    $('#reset-btn').html('Reset Password');
                }
            });
        }
    });
});

