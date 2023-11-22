<?php
include './includes/connection.php';

if (mysqli_connect_error()) {
    die('Connection failed: ' . mysqli_connect_error());
}

$sql = "SELECT COUNT(*) as count, event_type FROM events GROUP BY event_type";
$result = mysqli_query($conn, $sql);

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

$conn->close();

$data = array(
    "nonCompetitiveCount" => $nonCompetitiveCount,
    "CompetitiveCount" => $CompetitiveCount
);

header('Content-Type: application/json');

echo json_encode($data);
?>
