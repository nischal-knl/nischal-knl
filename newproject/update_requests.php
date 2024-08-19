<?php
session_start();
include 'db.php'; // Make sure you have a file to handle the DB connection

// Check if the teacher is logged in
if (!isset($_SESSION['teacher_id']) || !isset($_SESSION['faculty'])) {
    header('Location: teacher-login.php');
    exit;
}

$faculty = $_SESSION['faculty'];

$sql = "SELECT rollno, name, faculty, request_date 
        FROM update_requests 
        WHERE faculty =?
        ORDER BY request_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $faculty);
$stmt->execute();
$result = $stmt->get_result();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

       .container {
            width: 50%;
            margin: auto;
            text-align: center;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

       .link-button {
            color: blue;
            cursor: pointer;
            text-decoration: underline;
        }
    </style>
    <script>
        function handleRemoveRequest(rollno) {
            if (confirm('Are you sure you want to remove this update request?')) {
                // Send AJAX request to delete_request.php
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_request.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        alert('Request removed.');
                        window.location.reload();
                    }
                };
                xhr.send("rollno=" + rollno);
            }
        }

       
    </script>
</head>
<body>
    <div class="container">
        <h1>Update Requests</h1>
        <table>
            <thead>
                <tr>
                    <th>Roll No</th>
                    <th>Name</th>
                    <th>Faculty</th>
                    <th>Request Date</th>
                    <th>Update Result</th>
                    
                    <th>Remove Request</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['rollno']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['faculty']}</td>
                                <td>{$row['request_date']}</td>
                                <td><a href='update_result.php?rollno={$row['rollno']}'>Update Result</a></td>
                                
                                <td><span class='link-button' onclick=\"handleRemoveRequest('{$row['rollno']}')\">Remove Request</span></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No update requests found</td></tr>";
                }
               ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>