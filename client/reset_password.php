<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify if the token exists in the password_reset table
    $query = "SELECT * FROM password_reset WHERE token = '$token'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Token exists, show the reset password form
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <title>Reset Password</title>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <link rel='stylesheet' type='text/css' media='screen' href='login.css'>
        </head>
        <body>
            <!-- <div id="loader" style="display: none;">
                <img src="./images/loader.gif" alt="Loading..." />
            </div> -->
            <div class="login container p-5 my-5">
                <h3 class="mb-3">Reset Password</h3>
                <form class="row g-3" id="resetPasswordForm" method="POST" action="./update_password.php">
                    <input type="hidden" name="token" id="token" value="<?php echo $token; ?>">
                    <div class="col-12">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter New Password" required>
                        <div id="password-valid" class=""></div>
                    </div>
                    <div class="col-12">
                        <label for="cpassword" class="form-label">Confirm New Password</small></label>
                        <input type="password" class="form-control " id="cpassword" name="cpassword" placeholder="Confirm New Password" required>
                        <div id="cpassword-valid" class=""></div>
                    </div>
                    <div class="col-12 d-grid ">
                        <button class="btn-style btn btn-success" id="reset-btn" name="submit" type="submit">Reset Password</button>
                    </div>
                    <div class="form-group">
                        <a href="login.php" id="loginLink">Login</a>
                    </div>
                </form>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
            <script src="./reset_passwant_js.js"></script>
        </body>
        </html>
        <?php
    } else {
        // Token not found, show alert message and redirect to login page
        echo "<script>alert('Reset link has expired. Please try again.'); window.location.href = 'login.php';</script>";
    }
} else {
    // Token not provided, show alert message and redirect to login page
    echo "<script>alert('Reset link is invalid. Please try again.'); window.location.href = 'login.php';</script>";
}
?>
