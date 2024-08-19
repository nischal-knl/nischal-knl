<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $rollno = $_POST["rollno"];
    $password = $_POST["password"];
    $faculty = $_POST["faculty"];

    // Hash the password before storing
    $hashed_password = md5($password);

    $query = "INSERT INTO students (username, email, rollno, s_pass, faculty) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("sssss", $username, $email, $rollno, $hashed_password, $faculty);
        if ($stmt->execute()) {
            // Registration successful, redirect to login page
            header("Location: stud_login.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Database query failed";
    }
}

$conn->close();
?>
