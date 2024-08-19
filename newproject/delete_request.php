<?php
session_start();
include 'db.php'; // Make sure you have a file to handle the DB connection

// Check if the teacher is logged in
if (!isset($_SESSION['teacher_id']) || !isset($_SESSION['faculty'])) {
    header('Location: login_page.php');
    exit;
}

if (!isset($_POST['rollno'])) {
    header('Location: update_requests.php');
    exit;
}

$rollno = $_POST['rollno'];
$faculty = $_SESSION['faculty'];

// Delete the update request
$sql = "DELETE FROM update_requests WHERE rollno = ? AND EXISTS (SELECT 1 FROM students WHERE rollno = ? AND faculty = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $rollno, $rollno, $faculty);
$stmt->execute();

$stmt->close();
$conn->close();
?>
