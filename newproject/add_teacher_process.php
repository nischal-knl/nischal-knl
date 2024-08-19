<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: ". $conn->connect_error);
}

// Get form data
$teacherId = $_POST["t_id"];
$teacherName = $_POST["t_name"];
$teacherPassword = $_POST["t_pass"];
$faculty = $_POST["t_faculty"];
$hashedpass = password_hash($teacherPassword,PASSWORD_DEFAULT);
// Insert teacher data into database
$sql = "INSERT INTO teacher_table (t_id, t_name, t_pass, t_faculty) VALUES ('$teacherId', '$teacherName', '$hashedpass', '$faculty')";
if ($conn->query($sql) === TRUE) {
  echo "Teacher added successfully!";
} else {
  echo "Error: ". $sql. "<br>". $conn->error;
}

$conn->close();
?>