
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'db.php'; // this defines $conn

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: contact.html');
    exit;
}

$form_type = $_POST['form_type'] ?? 'contact';

function respondJson($payload) {
    header('Content-Type: application/json');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($form_type === 'application') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $dob        = trim($_POST['dob'] ?? '');
    $gender     = trim($_POST['gender'] ?? '');
    $programme  = trim($_POST['programme'] ?? '');
    $entry_type = trim($_POST['entry_type'] ?? '');
    $address    = trim($_POST['address'] ?? '');
    $motivation = trim($_POST['motivation'] ?? '');

    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($dob)
        || empty($gender) || empty($programme) || empty($entry_type) || empty($address)) {
        respondJson(['success' => false, 'error' => 'Please complete all required application fields.']);
    }

    $stmt = $conn->prepare(
        "INSERT INTO application_db.applications 
         (first_name, last_name, email, phone, dob, gender, programme, entry_type, address, motivation)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        respondJson(['success' => false, 'error' => 'Database prepare failed: ' . $conn->error]);
    }

    $stmt->bind_param('ssssssssss', $first_name, $last_name, $email, $phone, $dob, $gender, $programme, $entry_type, $address, $motivation);
    if ($stmt->execute()) {
        respondJson(['success' => true]);
    }

    respondJson(['success' => false, 'error' => $stmt->error]);
}

// Default: contact form submission
$first_name = trim(mysqli_real_escape_string($conn, $_POST['first_name'] ?? ''));
$last_name  = trim(mysqli_real_escape_string($conn, $_POST['last_name'] ?? ''));
$email      = trim(mysqli_real_escape_string($conn, $_POST['email'] ?? ''));
$phone      = trim(mysqli_real_escape_string($conn, $_POST['phone'] ?? ''));
$subject    = trim(mysqli_real_escape_string($conn, $_POST['subject'] ?? ''));
$message    = trim(mysqli_real_escape_string($conn, $_POST['message'] ?? ''));

if (empty($first_name) || empty($last_name) || empty($email) || empty($message)) {
    die("All fields are required.");
}

$stmt = $conn->prepare(
    "INSERT INTO contacts (first_name, last_name, email, phone, subject, message)
     VALUES (?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
}

$stmt->bind_param('ssssss', $first_name, $last_name, $email, $phone, $subject, $message);

if ($stmt->execute()) {
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
            \">" . htmlspecialchars($stmt->error) . "</p>
        </div>";
}

$stmt->close();
$conn->close();
?>
