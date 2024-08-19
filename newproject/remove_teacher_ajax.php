<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['t_id'])) {
    $t_id = $conn->real_escape_string($_POST['t_id']);
    
    // Check if the teacher exists
    $check_sql = "SELECT * FROM teacher_table WHERE t_id = '$t_id'";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        // Delete the teacher
        $delete_sql = "DELETE FROM teacher_table WHERE t_id = '$t_id'";
        if ($conn->query($delete_sql) === TRUE) {
            echo 'success';
        } else {
            echo 'failure';
        }
    } else {
        echo 'failure';
    }
}

$conn->close();
?>
