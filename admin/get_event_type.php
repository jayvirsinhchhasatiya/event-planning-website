<?php
// Connect to your MySQL database
include './includes/connection.php';

// Check connection
if (mysqli_connect_error()) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Query to retrieve the event type counts from the events table
$sql = "SELECT COUNT(*) as count, event_type FROM events GROUP BY event_type";
$result = mysqli_query($conn, $sql);

// Initialize variables
$nonCompetitiveCount = 0;
$CompetitiveCount = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row["event_type"] == "Non-Competitive") {
            $nonCompetitiveCount = $row["count"];
        } elseif ($row["event_type"] == "Competitive") {
            $CompetitiveCount = $row["count"];
        }
    }
}

// Close the database connection
$conn->close();

// Prepare the data to be sent as a JSON response
$data = array(
    "nonCompetitiveCount" => $nonCompetitiveCount,
    "CompetitiveCount" => $CompetitiveCount
);

// Set the response header to JSON
header('Content-Type: application/json');

// Send the JSON response
echo json_encode($data);
?>
