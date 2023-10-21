<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Forgot Password</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel='stylesheet' type='text/css' media='screen' href='login.css'>
</head>

<body>

  <div id="loader" style="display: none;">
    <img src="./images/loader.gif" alt="Loading..." />
  </div>

  <div class="login container p-5 my-5">
    <h3 class="mb-3">Forgot Password</h3>
    <form class="row g-3" id="forgotPasswordForm" method="POST" action="send_reset_link.php">

      <div class="col-12">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" required>
        <div id="email-valid" class="">

        </div>
      </div>

      <div class="col-12 d-grid ">
        <button class="btn-style btn btn-success"  id="reset-btn" name="submit" type="submit">Reset Password</button>
      </div>
      <div class="form-group">
        <a href="login.php" id="loginLink">Login</a>
      </div>
    </form>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="./forgot_password_email.js"></script>
</body>

</html>