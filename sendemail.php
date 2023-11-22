<?php
// Define some constants
define("RECIPIENT_NAME", "Basem Tawadrouse");
define("RECIPIENT_EMAIL", "basemtawadrouse@tawadrouse.com");
// define("RECIPIENT_EMAIL", "myabiti@gmail.com");

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Read the form values
$success = false;
$firstname = isset($_POST['firstname']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", "", $_POST['firstname']) : "";
$lastname = isset($_POST['lastname']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", "", $_POST['lastname']) : "";
$senderEmail = isset($_POST['email']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", "", $_POST['email']) : "";
$senderPhone = isset($_POST['phone']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", "", $_POST['phone']) : "";
$senderSubject = "Basem - Contact Form";
$message = isset($_POST['message']) ? preg_replace("/(From:|To:|BCC:|CC:|Message:|Content-Type:)/", "", $_POST['message']) : "";

// If all values exist, send the email
if ($firstname && $lastname && $senderEmail && $senderPhone && $message) {
    $recipient = RECIPIENT_NAME . " <" . RECIPIENT_EMAIL . ">";
    $subject = "Contact Form Submission";
    
    // Create a well-formatted HTML email body
    $msgBody = "<html>
        <body>
            <h2>Contact Form Submission</h2>
            <p><strong>Name:</strong> $firstname $lastname</p>
            <p><strong>Email:</strong> $senderEmail</p>
            <p><strong>Phone:</strong> $senderPhone</p>
            <p><strong>Subject:</strong> $senderSubject</p>
            <p><strong>Message:</strong> $message</p>
        </body>
    </html>";

    // Set the headers for an HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: " . $firstname . " " . $lastname . " <" . $senderEmail . ">";

    // Send the email
    $success = mail($recipient, $subject, $msgBody, $headers);

    if ($success) {
        // Email sent successfully
        $response = array('status' => 'Success', 'message' => 'Email sent successfully.');
    } else {
        // Email sending failed
        $response = array('status' => 'Error', 'message' => 'Failed to send the email. Please try again later.');
    }
} else {
    // Form fields are incomplete
    $response = array('status' => 'Error', 'message' => 'Please fill out all required fields.');
}

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
