
<?php
$host     = "localhost";
$user     = "root";       // default XAMPP user
$password = "";           // default XAMPP password is emptyvhfhfgdgdf
$database = "contact_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>