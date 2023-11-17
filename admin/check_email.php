<?php

include './includes/connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Assuming you have a database connection established
    $email = $_POST["email"];

    // Check if the email exists in the database
    $query = "SELECT COUNT(*) AS count FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];

    // Return the response based on the count
    if ($count > 0) {
        echo "false";
    } else {
        echo "true";
    }
}
?>

