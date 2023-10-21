<?php

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
}

include './includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = $_POST['event_id_delete'];

    // Delete the evnet from the database
    $deleteQuery = "DELETE FROM events WHERE id = $eventId";
    if (mysqli_query($conn, $deleteQuery)) {
        $response = [
            'success' => true,
            'message' => 'Event deleted successfully'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error deleting event. ' . mysqli_error($conn)
        ];
    }
} else {
    // Handle invalid request
    $response = [
        'success' => false,
        'message' => 'Invalid request'
    ];
}

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
