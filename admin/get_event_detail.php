<?php

include './includes/connection.php';

if (mysqli_connect_error()) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Fetch registration data from the database
$query = 'SELECT MONTH(event_date) AS month, COUNT(*) AS count FROM events GROUP BY MONTH(event_date)';
$result = mysqli_query($conn, $query);

// Prepare data for JSON encoding
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Send JSON response
header('Content-type: application/json');
echo json_encode($data);

mysqli_close($conn);
?>
