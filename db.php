
<?php
$host           = "localhost";
$user           = "root";       // default XAMPP user
$password       = "";           // default XAMPP password is empty
$contactDb      = "contact_db";
$applicationDb  = "application_db";

$conn = new mysqli($host, $user, $password, $contactDb);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset('utf8mb4');

// Ensure both databases and tables exist.
if (!$conn->query("CREATE DATABASE IF NOT EXISTS `{$applicationDb}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
    die("Database creation failed: " . $conn->error);
}

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