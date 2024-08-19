<?php
session_start();
$teacher_id = $_SESSION['teacher_id'];

// Check if the teacher is logged in
if (!isset($teacher_id)) {
  // Redirect to login page if not
  header('Location: teacher-login.php');
  exit;
}

// Connect to database
$conn = new mysqli("localhost", "root", "", "student_db");

// Prepare SQL query
$stmt = $conn->prepare("SELECT  s.rollno, s.username 
FROM students s
JOIN teacher_table t ON s.faculty = t.t_faculty
WHERE t.t_id = ? ;")

$stmt->bind_param("i", $teacher_id);

// Execute query
$stmt->execute();

// Fetch results
$result = $stmt->get_result();

// Format data as JSON
$students = [];
while ($row = $result->fetch_assoc()) {
  $students[] = $row;
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($students);

// Close database connection
$conn->close();
?>