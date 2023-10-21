<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Register</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel='stylesheet' type='text/css' media='screen' href='registration.css'>
  <!-- <script src='main.js'></script> -->
  <style>

  </style>
</head>

<body>
  <div class="registration container p-5 my-5">
    <h3 class="mb-3">Registration From</h3>
    <form class="row g-3" id="registrationForm" method="POST" action="formSubmit.php">

      <!-- first name -->
      <div class="col-md-6">
        <label for="firstname" class="form-label">First Name</label>
        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter Your First Name" required>
        <div id="firstname-valid" class="">
        </div>
      </div>

      <!-- last name -->
      <div class="col-md-6">
        <label for="lastname" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Your Last Name" required>
        <div id="lastname-valid" class="">
        </div>
      </div>

      <!-- user name -->
      <div class="col-md-6">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter Your Username" required>
        <div id="username-valid" class="">
        </div>
      </div>

      <!-- email -->
      <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" required>
        <div id="email-valid" class="">
        </div>
      </div>
      
      <!-- password -->
      <div class="col-md-6">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Your Password" required>
        <div id="password-valid" class="">
        </div>
      </div>

      <!-- confirm password -->
      <div class="col-md-6">
        <label for="cpassword" class="form-label">Confirm Password</small></label>
        <input type="password" class="form-control " id="cpassword" name="cpassword" placeholder="Confirm Your Password" required>
        <div id="cpassword-valid" class="">

        </div>
      </div>
      <div class="col-12 d-grid ">
        <button class="btn btn-primary" name="submit" type="submit">Register</button>
        <p class="login-register-text mt-2">Have an account? <a href="login.php">Login Here</a>.</p>
      </div>
    </form>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="./formvalidation.js"></script>
</body>

</html>