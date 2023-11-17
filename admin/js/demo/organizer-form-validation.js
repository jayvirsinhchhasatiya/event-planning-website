$(document).ready(function () {


    // Validate first name
    $('#firstname').on('keyup', function () {
        var firstname = $(this).val();
        // console.log(firstname);
        if (firstname == null || firstname == "") {
            $('#firstname').addClass('is-invalid');
            $('#firstname-valid').addClass('invalid-feedback');
            $('#firstname-valid').text('Enter your First name.');
        } else if (!firstname.match(/^[a-zA-Z ]*$/)) {
            $('#firstname').addClass('is-invalid');
            $('#firstname-valid').addClass('invalid-feedback');
            $('#firstname-valid').text('Enter proper First name.');
        } else {
            $('#firstname').removeClass('is-invalid');
            $('#firstname-valid').removeClass('invalid-feedback');
            $('#firstname').addClass('is-valid');
            $('#firstname-valid').addClass('valid-feedback');
            $('#firstname-valid').text('Looks good!');
        }
    });

    // Validate last name
    $('#lastname').on('keyup', function () {
        var lastname = $(this).val();
        if (lastname == null || lastname == "") {
            $('#lastname').addClass('is-invalid');
            $('#lastname-valid').addClass('invalid-feedback');
            $('#lastname-valid').text('Enter your Last name.');
        } else if (!lastname.match(/^[a-zA-Z ]*$/)) {
            $('#lastname').addClass('is-invalid');
            $('#lastname-valid').addClass('invalid-feedback');
            $('#lastname-valid').text('Enter proper Last name.');
        } else {
            $('#lastname').removeClass('is-invalid');
            $('#lastname-valid').removeClass('invalid-feedback');
            $('#lastname').addClass('is-valid');
            $('#lastname-valid').addClass('valid-feedback');
            $('#lastname-valid').text('Looks good!');
        }
    });

    // Validate username
    $('#username').on('keyup', function () {
        var username = $(this).val();
        if (username == null || username == "") {
            $('#username').addClass('is-invalid');
            $('#username-valid').addClass('invalid-feedback');
            $('#username-valid').text('Enter your username.');
        } else {
            $('#username').removeClass('is-invalid');
            $('#username-valid').removeClass('invalid-feedback');
            $('#username').addClass('is-valid');
            $('#username-valid').addClass('valid-feedback');
            $('#username-valid').text('Looks good!');
        }
    });

    // Validate email
    var emailValidated;
    $('#email').on('keyup', function () {
        var email = $(this).val();
        if (email == null || email == "") {
            $('#email').addClass('is-invalid');
            $('#email-valid').addClass('invalid-feedback');
            $('#email-valid').text('Enter your email.');
            emailValidated = false;
        } else if (!email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)) {
            $('#email').addClass('is-invalid');
            $('#email-valid').addClass('invalid-feedback');
            $('#email-valid').text('Enter a valid email address.');
            emailValidated = false;
        } else {
            $.ajax({
                url: 'check_email.php',
                method: 'POST',
                data: { email: email },
                success: function (response) {
                    if (response.trim() === "false") {
                        $('#email').addClass('is-invalid');
                        $('#email-valid').addClass('invalid-feedback');
                        $('#email-valid').text('Email already exists.');
                        emailValidated = false;
                    } else {
                        $('#email').removeClass('is-invalid');
                        $('#email-valid').removeClass('invalid-feedback');
                        $('#email').addClass('is-valid');
                        $('#email-valid').addClass('valid-feedback');
                        $('#email-valid').text('Looks good!');
                        emailValidated = true;
                    }
                }
            });
        }
    });


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
    $('#cpassword').on('keyup', function () {
        var password = $('#password').val().trim();
        var cpassword = $(this).val().trim();
        if (password !== cpassword) {
            $('#cpassword').addClass('is-invalid');
            $('#cpassword-valid').addClass('invalid-feedback');
            $('#cpassword-valid').text('Passwords do not match.');
        } else {
            $('#cpassword').removeClass('is-invalid');
            $('#cpassword-valid').removeClass('invalid-feedback');
            $('#cpassword').addClass('is-valid');
            $('#cpassword-valid').addClass('valid-feedback');
            $('#cpassword-valid').text('Password matched.');
        }
    });

    // Form submission
    var registrationForm = $('#organizerForm');
    registrationForm.on('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        // Check if email and phone are validated
        if (!emailValidated) {
            return false;
        }

        var form = $(this);
        var formData = form.serialize();

        // Send form data to backend
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: formData,
            success: function (response) {
                var response = response.trim();
                if (response === 'success') {
                    alert("Organizer added successfully!");
                    window.location.href = "index.php";
                    
                } else {
                    var errors = JSON.parse(response);
                    // Clear previous error messages
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').text('');

                    // Display the errors on the form
                    Object.keys(errors).forEach(function (key) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key + '-valid').addClass('invalid-feedback');
                        $('#' + key + '-valid').text(errors[key]);
                    });
                }
            },
            complete: function () {
                // Reset the form and remove the loader
                registrationForm[0].reset();
            }
        });
    });
});

