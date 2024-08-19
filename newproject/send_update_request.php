<?php
session_start();

// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'student_db';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rollno = $_SESSION['rollno'];
    $name = $_SESSION['username'];
    $faculty = $_SESSION['faculty']; // Assuming you have a session variable for faculty

    // Use a prepared statement to prevent SQL injection
    $sql = "REPLACE INTO update_requests (rollno, name, faculty) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $rollno, $name, $faculty);

    if ($stmt->execute()) {
        echo "Update request sent";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>