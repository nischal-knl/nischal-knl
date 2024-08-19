<?php
session_start();
include 'db.php'; // handling the DB connection

if (!isset($_SESSION['teacher_id']) || !isset($_SESSION['faculty'])) {
    header('Location: login_page.php');
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$rollno = $data['rollno'];
$faculty = $data['faculty'];

// Update the marks in the database
foreach ($data as $item) {
    if (isset($item['id']) && isset($item['marks'])) {
        $subject_id = $item['id'];
        $marks = $item['marks'];

        $sql = "UPDATE marks SET marks = ? WHERE rollno = ? AND subject_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $marks, $rollno, $subject_id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
?>