<?php
$host     = "localhost";
$user     = "root";
$password = "";
$database = "contact_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset('utf8mb4');

// Create application_submissions table inside contact_db if it doesn't exist
$conn->query("CREATE TABLE IF NOT EXISTS `contact_db`.`application_submissions` (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    first_name    VARCHAR(100) NOT NULL,
    last_name     VARCHAR(100) NOT NULL,
    email         VARCHAR(150) NOT NULL,
    phone         VARCHAR(50)  NOT NULL,
    dob           DATE,
    gender        VARCHAR(50),
    programme     VARCHAR(255),
    entry_type    VARCHAR(100),
    address       TEXT,
    motivation    TEXT,
    submitted_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Create contacts table inside contact_db if it doesn't exist
$conn->query("CREATE TABLE IF NOT EXISTS `contact_db`.`contacts` (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    first_name    VARCHAR(100) NOT NULL,
    last_name     VARCHAR(100) NOT NULL,
    email         VARCHAR(150) NOT NULL,
    phone         VARCHAR(50),
    subject       VARCHAR(150),
    message       TEXT NOT NULL,
    submitted_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
?>