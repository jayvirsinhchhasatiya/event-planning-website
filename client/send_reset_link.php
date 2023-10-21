<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include 'connection.php';

require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the email input
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    // Check if the email exists in the registration table
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];

        // Generate a unique token
        $token = bin2hex(random_bytes(32));

        // Store the token along with the user's email in the password_reset table
        $insertQuery = "INSERT INTO password_reset (email, token) VALUES ('$email', '$token')";
        mysqli_query($conn, $insertQuery);

        // Send the password reset email to the user
        $resetLink = "http://localhost/event_planning/client/reset_password.php?token=" . $token;
        $subject = "Password Reset";
        $message = "To reset your password, click the link below:\n\n" . $resetLink;

        // Configure the email settings
        $smtpHost = 'smtp.gmail.com';
        $smtpUsername = 'jayvirutube1011@gmail.com';
        $smtpPassword = 'ihccpvcvybpbjvmz';
        $smtpPort = 587;

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $smtpUsername;      //Your Gmail Id
            $mail->Password   = $smtpPassword;      //Your App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = $smtpPort;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($smtpUsername, 'Event Organizer');
            $mail->addAddress($email, $name);     //Add a recipient

            $mail->addReplyTo($smtpUsername, 'Event Organizer');


            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            // Send the email
            if ($mail->send()) {
                echo "success";
            } else {
                echo "error";
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email not found";
    }
}
