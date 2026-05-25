
<?php
require 'db.php';
header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

/* ── REGISTER ── */
if ($action === 'register') {
    $fullName  = trim($_POST['fullName']);
    $username  = trim($_POST['username']);
    $email     = trim($_POST['email']);
    $password  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $studentID = 'STU-' . rand(1000, 9999);

    $stmt = $conn->prepare(
        "INSERT INTO users (full_name, username, email, password, student_id)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("sssss", $fullName, $username, $email, $password, $studentID);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        // username or email already exists
        echo json_encode(['success' => false, 'message' => 'Username already exists']);
    }
}

/* ── LOGIN ── */
elseif ($action === 'login') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare(
        "SELECT full_name, student_id, password FROM users WHERE username = ?"
    );
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user   = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        echo json_encode([
            'success'    => true,
            'name'       => $user['full_name'],
            'studentID'  => $user['student_id']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid login details']);
    }
}

/* ── RESET PASSWORD ── */
elseif ($action === 'resetPassword') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "UPDATE users SET password = ?
         WHERE username = ? AND email = ?"
    );
    $stmt->bind_param("sss", $password, $username, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }
}
/* ── CHANGE PASSWORD ── */
elseif ($action === 'changePassword') {
    $studentID = trim($_POST['studentID']);
    $password  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "UPDATE users SET password = ? WHERE student_id = ?"
    );
    $stmt->bind_param("ss", $password, $studentID);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}

$conn->close();
?>