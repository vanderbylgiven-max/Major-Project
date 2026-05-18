
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize inputs
    $first_name = trim(mysqli_real_escape_string($conn, $_POST['first_name']));
    $last_name  = trim(mysqli_real_escape_string($conn, $_POST['last_name']));
    $email      = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $phone      = trim(mysqli_real_escape_string($conn, $_POST['phone']));
    $subject    = trim(mysqli_real_escape_string($conn, $_POST['subject']));
    $message    = trim(mysqli_real_escape_string($conn, $_POST['message']));

    // Validate
    if (empty($first_name) || empty($last_name) || empty($email) || empty($message)) {
        die("All fields are required.");
    }

    // Insert into database
    $sql = "INSERT INTO contacts (first_name, last_name, email, phone, subject, message)
            VALUES ('$first_name', '$last_name', '$email', '$phone', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "Message received! Thank you, " . $first_name . ".";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();

} // ← this closing brace closes the if($_SERVER) block

?>