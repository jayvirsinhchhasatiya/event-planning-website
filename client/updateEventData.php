<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include 'connection.php';

require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // print_r($_POST);
    // die();
    $eventId = $_POST['eventId']; // Assuming you have eventId in your form
    $eventName = $_POST['eventName'];
    $eventType = $_POST['eventType'];
    $eventDescription = $_POST['eventDescription'];
    $eventDate = $_POST['eventDate'];
    $eventTime = $_POST['eventTime'];
    $venue = $_POST['venue'];

    $errors = array(); // Array to store validation errors

    // Validate event name
    if (empty($eventName)) {
        $errors["eventName"] = "Event Name is required.";
    }

    // Validate event type
    if (empty($eventType) || $eventType === "Default") {
        $errors["eventType"] = "Select a valid event type.";
    }

    // If there are no validation errors
    if (empty($errors)) {
        // Update event data in the events table
        $updateEventQuery = "UPDATE events 
                             SET event_name = '$eventName', event_type = '$eventType', 
                             event_description = '$eventDescription', event_date = '$eventDate', 
                             event_time = '$eventTime', venue = '$venue' 
                             WHERE event_id = $eventId";

        $result = mysqli_query($conn, $updateEventQuery);

        if ($result) {
            $organizerEmail = $_SESSION['client'];

            // Retrieve the password from the database
            $passwordQuery = "SELECT password FROM user_credentials WHERE email='$organizerEmail'";
            $passwordResult = mysqli_query($conn, $passwordQuery);
            $row = mysqli_fetch_assoc($passwordResult);
            $organizerPassword = $row['password'];
            // Check if tasks are provided
            if (isset($_POST['tasks'])) {
                // Process tasks
                foreach ($_POST['tasks'] as $taskId => $task) {
                    $taskDescription = mysqli_real_escape_string($conn, $task['description']);
                    $assigneeEmails = explode(',', $task['assignees']);

                    // Update task details in the tasks table
                    $updateTaskQuery = "UPDATE tasks 
                                        SET task_description = '$taskDescription' 
                                        WHERE task_id = $taskId";

                    $resultTask = mysqli_query($conn, $updateTaskQuery);

                    // Process assignees for the task
                    if ($resultTask) {
                        // Delete existing assignees for the task
                        $deleteAssigneesQuery = "DELETE FROM assignees WHERE task_id = $taskId";
                        mysqli_query($conn, $deleteAssigneesQuery);

                        // Insert new assignees
                        foreach ($assigneeEmails as $assigneeEmail) {
                            $assigneeEmail = trim($assigneeEmail); // Remove leading/trailing spaces

                            // Insert assignee details into the assignees table
                            $insertAssigneeQuery = "INSERT INTO assignees (task_id, assignee_email) 
                                                   VALUES ($taskId, '$assigneeEmail')";
                            mysqli_query($conn, $insertAssigneeQuery);

                            // Send email notification to the assignee
                            sendTaskUpdateEmail($organizerEmail, $organizerPassword, $assigneeEmail, $eventName, $taskDescription);
                        }
                    }
                }
            }

            // Event update successful, show alert
            echo 'success';
            exit;
        } else {
            $errors["database"] = "Error occurred while updating data in the events table.";
            echo json_encode($errors);
            exit;
        }
    } else {
        echo json_encode($errors);
        exit;
    }
}

function sendTaskUpdateEmail($organizerEmail, $organizerPassword, $assigneeEmail, $eventName, $taskDescription)
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $organizerEmail;
        $mail->Password   = $organizerPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom($organizerEmail, 'Event Organizer');
        $mail->addAddress($assigneeEmail);
        $mail->addReplyTo($organizerEmail, 'Event Organizer');

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Task Updated for Event: $eventName";
        $mail->Body    = "One of the tasks for the event '$eventName' has been updated.<br><br>Updated Task Description: $taskDescription";

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$e->getMessage()}";
    }
}
