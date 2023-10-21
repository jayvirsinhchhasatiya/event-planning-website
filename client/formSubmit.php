<?php

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $errors = array(); // Array to store validation errors

    // Validate firstname
    if (empty($firstname)) {
        $errors["firstname"] = "First Name is required.";
    } else if (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
        $errors["firstname"] = "Enter a valid name.";
    }
    // Validate lastname
    if (empty($lastname)) {
        $errors["lastname"] = "Last Name is required.";
    } else if (!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
        $errors["lastname"] = "Enter a valid name.";
    }
    // Validate username
    if (empty($username)) {
        $errors["username"] = "Username is required.";
    }

    // Validate email
    if (empty($email)) {
        $errors["email"] = "Email is required.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Enter a valid email address.";
    } else {
        // Check if email already exists in the database
        $emailQuery = "SELECT * FROM users WHERE email='$email'";
        $emailResult = mysqli_query($conn, $emailQuery);
        if (mysqli_num_rows($emailResult) > 0) {
            $errors["email"] = "Email already exists.";
        }
    }

    // Validate password
    if (empty($password)) {
        $errors["password"] = "Password is required.";
    } else if (strlen($password) <= 4) {
        $errors["password"] = "Password should contain at least 5 characters.";
    }

    // Validate confirm password
    if (empty($cpassword)) {
        $errors["cpassword"] = "Confirm password is required.";
    } else if ($password !== $cpassword) {
        $errors["cpassword"] = "Passwords do not match.";
    }

    // If there are no validation errors
    if (empty($errors)) {

        // Generate a secure hash of the password
        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertquery = "INSERT INTO `users`(`first_name`, `last_name`,`username`, `email`, `password`, `user_type`) VALUES ('$firstname','$lastname','$username','$email',' $password','organizer')";

        $query = mysqli_query($conn, $insertquery);
        if ($query) {
            echo 'success';
            exit;
        } else {
            $errors["database"] = "Error occurred while inserting data into the database.";
            echo json_encode($errors);
            exit;
        }
        
    } else {
        echo json_encode($errors);
        exit;
    }
}
