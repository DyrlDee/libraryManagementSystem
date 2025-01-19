<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "librarylms";

// Create connection with XAMPP MySQL socket path
$conn = new mysqli($servername, $username, $password, $dbname, null, '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>