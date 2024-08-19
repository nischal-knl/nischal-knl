<?php
session_start();
include 'db.php'; // handling the DB connection

// Check if the teacher is logged in
if (!isset($_SESSION['teacher_id']) || !isset($_SESSION['faculty'])) {
    header('Location: login_page.php');
    exit;
}

if (!isset($_GET['rollno'])) {
    header('Location: update_requests.php');
    exit;
}

$rollno = $_GET['rollno'];
$faculty = $_SESSION['faculty'];

// Fetch the marks of the student
$sql = "SELECT m.rollno, m.marks, s.subject_name, s.subject_id 
        FROM marks m 
        JOIN subjects s ON m.subject_id = s.subject_id 
        JOIN students st ON m.rollno = st.rollno
        WHERE m.rollno = ? AND st.faculty = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "Error preparing statement: " . $conn->error;
    exit;
}
$stmt->bind_param("ss", $rollno, $faculty);
$stmt->execute();
if (!$stmt) {
    echo "Error executing statement: " . $conn->error;
    exit;
}
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Result</title>
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

        .update-btn {
            background-color: rgb(100, 149, 237);
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        .update-btn:hover {
            background-color: rgb(65, 105, 225);
        }
    </style>
    <script>
        function updateMarks() {
            let marksData = [];

            document.querySelectorAll('.marks-input').forEach(input => {
                marksData.push({
                    id: input.dataset.id,
                    marks: input.value
                });
            });

            marksData.push({
                rollno: "<?php echo $rollno; ?>",
                faculty: "<?php echo $_SESSION['faculty']; ?>"
            });

            console.log(marksData);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_marks.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert('Marks updated successfully!');
                    window.location.href = 'teacher_dashboard.php';
                } else {
                    alert('Failed to update marks.');
                }
            };
            xhr.send(JSON.stringify(marksData));
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Update Marks for Roll No: <?php echo htmlspecialchars($rollno); ?></h1>
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Marks</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['subject_name']}</td>
                                <td><input type='number' class='marks-input' data-id='{$row['subject_id']}' value='{$row['marks']}'></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No marks found for this student</td></tr>";
                }
                ?>
            </tbody>
        </table><br>
        <button class="update-btn" onclick="updateMarks()">Update Marks</button>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>