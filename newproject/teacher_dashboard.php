<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header('Location: teacher-login.php');
    exit;
}
include 'db.php'; // Make sure you have a file to handle the DB connection

$teacher_id = $_SESSION['teacher_id'];
$faculty = $_SESSION['faculty'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="style/styles_teacher.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="header">
        <img src="logo.png" alt="Logo">
        <h2>Teacher Dashboard</h2>
        <div class="menu">
        <a href="add_result_all.php">Add Results</a>
            <a href="update_requests.php">View Update Request</a>
            <a href="change_password_teacher.php">Change Password</a>
            <a href="logout.php">Logout</a>
            
        </div>
    </div>
    <div class="content">
        <h2>Students in Faculty: <?php echo htmlspecialchars($faculty); ?></h2>
        <table id="students-table">
            <thead>
                <tr>
                    <th>Roll No</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT rollno, username FROM students WHERE faculty = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $faculty);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['rollno']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
