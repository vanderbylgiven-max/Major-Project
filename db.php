<?php
$host           = "localhost";
$user           = "root";
$password       = "";
$contactDb      = "contact_db";
$applicationDb  = "application_db";

// Connect without selecting a default database so we can create DBs if missing
$conn = new mysqli($host, $user, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset('utf8mb4');

// Ensure both databases exist
if (!$conn->query("CREATE DATABASE IF NOT EXISTS `{$contactDb}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
    die("Database creation failed (contact DB): " . $conn->error);
}

if (!$conn->query("CREATE DATABASE IF NOT EXISTS `{$applicationDb}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
    die("Database creation failed (application DB): " . $conn->error);
}

// Create contacts table inside contact_db if it doesn't exist
$contactTableSql = "CREATE TABLE IF NOT EXISTS `{$contactDb}`.`contacts` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(50),
    subject VARCHAR(150),
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!$conn->query($contactTableSql)) {
    die("Contacts table creation failed: " . $conn->error);
}

// Create applications table inside application_db if it doesn't exist
$applicationTableSql = "CREATE TABLE IF NOT EXISTS `{$applicationDb}`.`applications` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    dob DATE NOT NULL,
    gender VARCHAR(50) NOT NULL,
    programme VARCHAR(255) NOT NULL,
    entry_type VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    motivation TEXT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!$conn->query($applicationTableSql)) {
    die("Applications table creation failed: " . $conn->error);
}
?>