<?php

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $token = $_POST["token"];
  $newPassword = $_POST["password"];

  // Verify if the token exists in the password_reset table
  $query = "SELECT * FROM password_reset WHERE token = '$token'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    // Token exists, update the password in the registration table
    $row = mysqli_fetch_assoc($result);
    $email = $row['email'];

    // Hash the new password
    // $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password in the registration table
    $updateQuery = "UPDATE users SET password = '$newPassword' WHERE email = '$email'";
    mysqli_query($conn, $updateQuery);

    // Delete the token from the password_reset table
    $deleteQuery = "DELETE FROM password_reset WHERE token = '$token'";
    mysqli_query($conn, $deleteQuery);

    echo "success";
  } else {
    // Token not found
    echo "token_error";
  }
}

?>
