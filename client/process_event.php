<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include 'connection.php';

require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

session_start();
if (!isset($_SESSION['client'])) {

    echo '<script>
        alert("Please login to continue");
        window.location.href = "login.php";
        </script>';
    // header("Location: index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // print_r($_POST);
    // die();
    $eventName = $_POST['eventName'];
    $eventType = $_POST['eventType'];
    $eventDescription = $_POST['eventDescription'];
    $eventDate = $_POST['eventDate'];
    $eventTime = $_POST['eventTime'];
    $venue = $_POST['venue'];
    $eventId = 0;

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
        $organizerEmail = $_SESSION['client'];
        $organizerQuery = "SELECT * FROM users WHERE email='$organizerEmail'";
        $organizerResult = mysqli_query($conn, $organizerQuery);

        // Retrieve the password from the database
        $passwordQuery = "SELECT password FROM user_credentials WHERE email='$organizerEmail'";
        $passwordResult = mysqli_query($conn, $passwordQuery);
        $row = mysqli_fetch_assoc($passwordResult);
        $organizerPassword = $row['password'];

        if ($organizerResult) {
            $organizer = mysqli_fetch_assoc($organizerResult);

            // Insert event data into the events table
            $insertEventQuery = "INSERT INTO events (event_name, event_type, event_description, event_date, event_time, venue, organizer_id) VALUES ('$eventName', '$eventType', '$eventDescription', '$eventDate', '$eventTime', '$venue', '{$organizer['user_id']}')";

            $result = mysqli_query($conn, $insertEventQuery);

            // print_r($result);

            if ($result) {
                // print_r("inside result");
                // Update eventId with the last inserted ID
                $eventId = mysqli_insert_id($conn);

                // Check if participants are provided
                if (isset($_POST['participant'])) {
                    $participantEmails = explode(',', $_POST['participant']);

                    // Insert participant details into the participants table
                    foreach ($participantEmails as $participantEmail) {
                        $participantEmail = trim($participantEmail); // Remove leading/trailing spaces

                        $insertParticipantQuery = "INSERT INTO participants (event_id, participant_email) 
                VALUES ('$eventId', '$participantEmail')";
                        mysqli_query($conn, $insertParticipantQuery);

                        // Send email notification to the participant
                        sendEventDetailsEmail($organizerEmail, $organizerPassword, $participantEmail, $eventName, $eventDate, $eventTime, $venue, $eventDescription);
                    }
                }

                // Check if tasks are provided
                if (isset($_POST['tasks'])) {
                    // Process tasks
                    foreach ($_POST['tasks'] as $task) {
                        $taskDescription = mysqli_real_escape_string($conn, $task['description']);
                        $assigneeEmails = explode(',', $task['assignees']);

                        // Insert task details into the tasks table
                        $insertTaskQuery = "INSERT INTO tasks (event_id, task_description) 
                        VALUES ('$eventId', '$taskDescription')";
                        $result = mysqli_query($conn, $insertTaskQuery);

                        // Get the last inserted task ID
                        $taskId = mysqli_insert_id($conn);

                        // Process assignees for the task
                        foreach ($assigneeEmails as $assigneeEmail) {
                            $assigneeEmail = trim($assigneeEmail); // Remove leading/trailing spaces
                            // Insert assignee details into the assignees table
                            $insertAssigneeQuery = "INSERT INTO assignees (task_id, assignee_email) 
                               VALUES ('$taskId', '$assigneeEmail')";
                            mysqli_query($conn, $insertAssigneeQuery);

                            // Send email notification to the assignee
                            sendTaskNotificationEmail($organizerEmail, $organizerPassword, $assigneeEmail, $eventName, $taskDescription);
                        }
                    }
                }

                // Event creation successful, send email
                sendEventCreationEmail($organizerEmail, $organizerPassword, $eventName);

                // Show alert
                echo 'success';
                exit;
            } else {
                $errors["database"] = "Error occurred while inserting data into the events table.";
                echo json_encode($errors);
                exit;
            }
        } else {
            $errors["database"] = "Error occurred while querying the database for the organizer.";
            echo json_encode($errors);
            exit;
        }
    } else {
        echo json_encode($errors);
        exit;
    }
}


function sendEventCreationEmail($organizerEmail, $organizerPassword, $eventName)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $organizerEmail;
        $mail->Password   = $organizerPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom($organizerEmail, 'Event Organizer');
        $mail->addAddress($organizerEmail);
        $mail->addReplyTo($organizerEmail, 'Event Organizer');
        $mail->isHTML(true);
        $mail->Subject = "Event Created Successfully";
        $mail->Body    = "Your event '$eventName' has been successfully created.";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$e->getMessage()}";
    }
}

function sendTaskNotificationEmail($organizerEmail, $organizerPassword, $assigneeEmail, $eventName, $taskDescription)
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
        $mail->Subject = "New Task Assignment for Event: $eventName";
        $mail->Body    = "You have been assigned a new task for the event '$eventName'.<br><br>Task Description: $taskDescription";

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$e->getMessage()}";
    }
}

function sendEventDetailsEmail($organizerEmail, $organizerPassword, $participantEmail, $eventName, $eventDate, $eventTime, $venue, $eventDescription)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $organizerEmail;
        $mail->Password   = $organizerPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom($organizerEmail, 'Event Organizer');
        $mail->addAddress($participantEmail);
        $mail->addReplyTo($organizerEmail, 'Event Organizer');
        $mail->isHTML(true);
        $mail->Subject = "Event Details: $eventName";
        $mail->Body    = "Dear students and faculty members,<br><br>
                          We are organizing another event...<br><br>
                          Take a part of of the event '$eventName'.<br><br>
                          Event Details:<br>
                          - Date: $eventDate<br>
                          - Time: $eventTime<br>
                          - Venue: $venue<br>
                          - Description: $eventDescription<br><br>
                          We look forward to seeing you there!<br><br>
                          Best regards,<br>
                          Event Organizer";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$e->getMessage()}";
    }
}
