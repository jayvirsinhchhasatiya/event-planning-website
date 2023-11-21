<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include 'connection.php';

require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

session_start();
// print_r($_SESSION);

if (!isset($_SESSION['client'])) {
    echo '<script>
        alert("Please login to continue");
        window.location.href = "login.php";
        </script>';
}

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['eventId'])) {
    $eventId = $_POST['eventId'];

    // Get event details
    $selectEventQuery = "SELECT * FROM events WHERE event_id='$eventId'";
    $eventQuery = mysqli_query($conn, $selectEventQuery);
    $event = mysqli_fetch_assoc($eventQuery);

    if ($event) {
        $eventDate = $event['event_date'];

        // Check if the event date is in the future
        $today = date('Y-m-d');
        if ($eventDate >= $today) {
            // Fetch associated tasks
            $selectTasksQuery = "SELECT task_id FROM tasks WHERE event_id='$eventId'";
            $tasksQuery = mysqli_query($conn, $selectTasksQuery);

            while ($task = mysqli_fetch_assoc($tasksQuery)) {
                $taskId = $task['task_id'];

                // Fetch assignees for each task
                $selectAssigneesQuery = "SELECT assignee_email FROM assignees WHERE task_id='$taskId'";
                $assigneesQuery = mysqli_query($conn, $selectAssigneesQuery);

                while ($assignee = mysqli_fetch_assoc($assigneesQuery)) {
                    $assigneeEmail = $assignee['assignee_email'];

                    $organizerEmail = $_SESSION['client'];
                    $organizerQuery = "SELECT * FROM users WHERE email='$organizerEmail'";
                    $organizerResult = mysqli_query($conn, $organizerQuery);

                    // Retrieve the password from the database
                    $passwordQuery = "SELECT password FROM user_credentials WHERE email='$organizerEmail'";
                    $passwordResult = mysqli_query($conn, $passwordQuery);
                    $row = mysqli_fetch_assoc($passwordResult);
                    $organizerPassword = $row['password'];
                    $eventName = $event['event_name'];

                    // Send email notification to the assignee
                    sendTaskNotificationEmail($organizerEmail, $organizerPassword, $assigneeEmail, $eventName);
                }

                // Delete assignees for the current task
                $deleteAssigneesQuery = "DELETE FROM assignees WHERE task_id='$taskId'";
                mysqli_query($conn, $deleteAssigneesQuery);
            }

            // Delete tasks for the current event
            $deleteTasksQuery = "DELETE FROM tasks WHERE event_id='$eventId'";
            mysqli_query($conn, $deleteTasksQuery);

            // Delete the event
            $deleteEventQuery = "DELETE FROM events WHERE event_id='$eventId'";
            $result = mysqli_query($conn, $deleteEventQuery);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Event deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error deleting event.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Cannot delete past events.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Event not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

function sendTaskNotificationEmail($organizerEmail, $organizerPassword, $assigneeEmail, $eventName)
{
    // Configure the email settings
    $smtpHost = 'smtp.gmail.com';
    $smtpUsername = $organizerEmail;
    $smtpPassword = $organizerPassword;
    $smtpPort = 587;

    $mail = new PHPMailer(true);

    try {
        // Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host       = $smtpHost;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtpUsername;
        $mail->Password   = $smtpPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $smtpPort;

        // Recipients
        $mail->setFrom($smtpUsername, 'Event Organizer');
        $mail->addAddress($assigneeEmail);
        $mail->addReplyTo($smtpUsername, 'Event Organizer');

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Event Cancellation Notification";
        $mail->Body    = "Dear Assignee,\n\nThe event '$eventName' has been canceled.\n\nRegards,\nEventPlanner";

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
