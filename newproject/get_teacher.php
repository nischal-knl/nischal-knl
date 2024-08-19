<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT t_id, t_name, t_faculty FROM teacher_table";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<tr id="teacher-' . $row['t_id'] . '">
                <td>' . $row['t_id'] . '</td>
                <td>' . $row['t_name'] . '</td>
                <td>' . $row['t_faculty'] . '</td>
              </tr>';
    }
} else {
    echo '<tr><td colspan="3">No teachers found.</td></tr>';
}

$conn->close();
?>
