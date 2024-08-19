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
  die("Connection failed: " . $conn->connect_error);
}

// Get faculty from URL parameter
$faculty = $_GET["faculty"];

// Fetch student data
$sql = "SELECT rollno, username, faculty FROM students WHERE faculty = '$faculty'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<table id='student-table'>";
  echo "<tr><th>Roll No</th><th>Name</th><th>Faculty</th></tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["rollno"] . "</td>";
    echo "<td>" . $row["username"] . "</td>";
    echo "<td>" . $row["faculty"] . "</td>";
    echo "</tr>";
  }
  echo "</table>";
} else {
  echo "No students found.";
}

$conn->close();
?>