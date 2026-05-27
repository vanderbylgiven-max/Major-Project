<?php
ini_set('display_errors', 0);
error_reporting(0);

ob_start();

require 'db.php';

function respondJson($payload) {
    while (ob_get_level()) ob_end_clean();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: contact.html');
    exit;
}

$form_type = $_POST['form_type'] ?? 'contact';

// ── APPLICATION FORM ──────────────────────────────────────────────────────────
if ($form_type === 'application') {

    $first_name  = trim($_POST['first_name']  ?? '');
    $last_name   = trim($_POST['last_name']   ?? '');
    $email       = trim($_POST['email']       ?? '');
    $phone       = trim($_POST['phone']       ?? '');
    $dob         = trim($_POST['dob']         ?? '');
    $gender      = trim($_POST['gender']      ?? '');
    $programme   = trim($_POST['programme']   ?? '');
    $entry_type  = trim($_POST['entry_type']  ?? '');
    $address     = trim($_POST['address']     ?? '');
    $motivation  = trim($_POST['motivation']  ?? '');

    if (empty($first_name) || empty($last_name) || empty($email) ||
        empty($phone) || empty($gender) || empty($programme) ||
        empty($entry_type) || empty($address)) {
        respondJson(['success' => false,
                     'error'   => 'Please complete all required fields.']);
    }

    // Build SQL pointing to the applications table in the application DB
    $appDb = isset($applicationDb) && $applicationDb ? $applicationDb : 'application_db';
    $sql = "INSERT INTO `" . $conn->real_escape_string($appDb) . "`.`applications` ";
    $sql .= "(first_name, last_name, email, phone, dob, gender, programme, entry_type, address, motivation) ";
    $sql .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        respondJson(['success' => false,
                     'error'   => 'Database error: ' . $conn->error]);
    }

    $stmt->bind_param('ssssssssss',
        $first_name, $last_name, $email, $phone, $dob,
        $gender, $programme, $entry_type, $address, $motivation
    );

    if ($stmt->execute()) {
        respondJson(['success' => true]);
    } else {
        respondJson(['success' => false, 'error' => $stmt->error]);
    }
}

// ── CONTACT FORM ──────────────────────────────────────────────────────────────
$first_name = trim($_POST['first_name'] ?? '');
$last_name  = trim($_POST['last_name']  ?? '');
$email      = trim($_POST['email']      ?? '');
$phone      = trim($_POST['phone']      ?? '');
$subject    = trim($_POST['subject']    ?? '');
$message    = trim($_POST['message']    ?? '');

if (empty($first_name) || empty($last_name) ||
    empty($email) || empty($message)) {
    while (ob_get_level()) ob_end_clean();
    die("All fields are required.");
}

$stmt = $conn->prepare("
    INSERT INTO contacts
        (first_name, last_name, email, phone, subject, message)
    VALUES (?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    while (ob_get_level()) ob_end_clean();
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param('ssssss',
    $first_name, $last_name, $email, $phone, $subject, $message
);

if ($stmt->execute()) {
    while (ob_get_level()) ob_end_clean();
    echo "
    <div style='max-width:800px;margin:80px auto;padding:40px;
                background:rgba(255,255,255,0.05);backdrop-filter:blur(10px);
                border:1px solid rgba(255,255,255,0.1);border-radius:12px;
                text-align:center;color:#f4f4f4;font-family:Inter,sans-serif;'>
        <h1 style='font-size:2rem;font-weight:800;color:#ffcc00;margin-bottom:20px;'>
            Message received!
        </h1>
        <p style='font-size:1rem;color:#aaaaaa;margin-bottom:30px;'>
            Thank you, " . htmlspecialchars($first_name) . ".
        </p>
        <a href='index.html' style='display:inline-block;padding:10px 22px;
            background:#e21f26;color:#fff;text-decoration:none;border-radius:4px;
            font-weight:700;'>Return Home</a>
    </div>";
} else {
    while (ob_get_level()) ob_end_clean();
    echo "<p style='color:red;text-align:center;margin-top:80px;'>
            Error: " . htmlspecialchars($stmt->error) . "
          </p>";
}

$stmt->close();
$conn->close();
?>