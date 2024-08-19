<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header('Location: teacher-login.php');
    exit;
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_id = $_POST['subject_id'];
    $marks = $_POST['marks'];

    $errors = [];

    foreach ($marks as $roll_no => $mark) {
        if (!empty($mark) && is_numeric($mark)) {
            $query = "INSERT INTO marks (rollno, subject_id, marks) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE marks=?";
            $stmt = $conn->prepare($query);
            if ($stmt) {
                $stmt->bind_param("ssss", $roll_no, $subject_id, $mark, $mark);
                $stmt->execute();
                if ($stmt->affected_rows < 1) {
                    $errors[] = "Error adding result for roll number: $roll_no";
                }
                $stmt->close();
            } else {
                error_log("Error preparing statement for roll number: $roll_no");
                $errors[] = "Error preparing statement for roll number: $roll_no";
            }
        } else {
            error_log("Invalid mark for roll number: $roll_no");
            $errors[] = "Invalid mark for roll number: $roll_no";
        }
    }

    $conn->close();

    if (empty($errors)) {
        echo "Results successfully added.";
    } else {
        echo "Errors encountered: " . implode(", ", $errors);
    }
} else {
    echo "Invalid request method.";
}
?>
