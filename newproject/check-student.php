<?php
$conn = mysqli_connect("localhost", "root", "", "student_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$rollno = $_GET['rollno'];

$query = "SELECT * FROM students WHERE rollno = '$rollno'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo 'true';
} else {
    echo 'false';
}

mysqli_close($conn);
?>
