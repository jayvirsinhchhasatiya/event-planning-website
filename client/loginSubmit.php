<?php

session_start();

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = array(); // Array to store validation errors

    // Validate email
    if (empty($email)) {
        $errors["email"] = "Email is required.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Enter a valid email address.";
    }

    // Validate password
    if (empty($password)) {
        $errors["password"] = "Password is required.";
    }

    // If there are no validation errors
    if (empty($errors)) {
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                if ($user['user_type'] === 'organizer' && $user['password'] == $password) {

                    $_SESSION['client'] = $email;
                    
                    echo 'success';
                    exit;
                } else {
                    $errors["database"] = "Invalid credentials or account not approved..";
                    echo json_encode($errors);
                    exit;
                }
            } else {
                $errors["database"] = "Invalid email.";
                echo json_encode($errors);
                exit;
            }
        } else {
            $errors["database"] = "Error occurred while querying the database.";
            echo json_encode($errors);
            exit;
        }
    } else {
        echo json_encode($errors);
        exit;
    }
}
