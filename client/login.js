$(document).ready(function () {

    // Validate email
    $('#email').on('blur', function () {
        var email = $(this).val();
        if (email == null || email == "") {
            $('#email').addClass('is-invalid');
            $('#email-valid').addClass('invalid-feedback');
            $('#email-valid').text('Enter your email.');
        } else if (!email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)) {
            $('#email').addClass('is-invalid');
            $('#email-valid').addClass('invalid-feedback');
            $('#email-valid').text('Enter a valid email address.');
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
                    } else {
                        $('#email').removeClass('is-invalid');
                        $('#email-valid').removeClass('invalid-feedback');
                        $('#email-valid').text('');
                    }
                }
            });
        }
    });

    // Validate password
    $('#password').on('blur', function () {
        var password = $('#password').val().trim();
        if (password == null || password == "") {
            $('#password').addClass('is-invalid');
            $('#password-valid').addClass('invalid-feedback');
            $('#password-valid').text('Enter password.');
        } else {
            $('#password').removeClass('is-invalid');
            $('#password-valid').removeClass('invalid-feedback');
            $('#password-valid').text('');
        }
    });

    // Form submission
    $('#loginForm').on('submit', function (event) {
        event.preventDefault();

        var email = $('#email').val().trim();
        var password = $('#password').val().trim();

        // Perform back-end validation
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: {
                email: email,
                password: password
            },
            success: function (response) {
                // alert(response);
                if (response === 'success') {
                    // alert("login success");
                    window.location.href = "index.php";
                } else {
                    alert('Login failed');
                }
            }
        });
    });
});
