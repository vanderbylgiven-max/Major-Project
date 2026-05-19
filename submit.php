
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'db.php'; // this defines $conn

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

    // Build SQL
    $sql = "INSERT INTO contacts (first_name, last_name, email, phone, subject, message)
            VALUES ('$first_name', '$last_name', '$email', '$phone', '$subject', '$message')";

    // Run query
    if ($conn->query($sql) === TRUE) {
        echo "<div style=\"
            max-width:800px;
            margin:80px auto;
            padding:40px;
            background:rgba(255,255,255,0.05);
            backdrop-filter:blur(10px);
            border:1px solid rgba(255,255,255,0.1);
            border-radius:12px;
            text-align:center;
            color:#f4f4f4;
            font-family:'Inter',sans-serif;
        \">
            <h1 style=\"
                font-size:2rem;
                font-weight:800;
                color:#ffcc00;
                margin-bottom:20px;
            \">Message received!</h1>
            <p style=\"
                font-size:1rem;
                color:#aaaaaa;
                margin-bottom:30px;
            \">Thank you, " . htmlspecialchars($first_name) . ".</p>
            <a href='index.html' style=\"
                display:inline-block;
                padding:10px 22px;
                background:#e21f26;
                color:#fff;
                text-decoration:none;
                border-radius:4px;
                font-weight:700;
                border:2px solid #e21f26;
                transition:0.3s;
            \">Return Home</a>
        </div>";
    } else {
        echo "<div style=\"
            max-width:800px;
            margin:80px auto;
            padding:40px;
            background:rgba(226,31,38,0.08);
            border:1.5px dashed #e21f26;
            border-radius:12px;
            text-align:center;
            color:#f4f4f4;
            font-family:'Inter',sans-serif;
        \">
            <h1 style=\"
                font-size:2rem;
                font-weight:800;
                color:#e21f26;
                margin-bottom:20px;
            \">Error</h1>
            <p style=\"
                font-size:1rem;
                color:#aaaaaa;
            \">" . htmlspecialchars($conn->error) . "</p>
        </div>";
    }

    $conn->close();
}
?>
