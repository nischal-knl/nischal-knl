<?php
header('Content-Type: application/json');

// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'student_db';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rollno = $_POST["roll_no"];

    // Fetch student marks and subjects
    $sql = "SELECT s.subject_name, m.marks
            FROM marks m
            JOIN subjects s ON m.subject_id = s.subject_id
            WHERE m.rollno = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $rollno);
    $stmt->execute();
    $result = $stmt->get_result();

    $marks_data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $marks_data[] = [
                'subject_name' => $row['subject_name'],
                'marks' => $row['marks']
            ];
        }

        // Calculate total and percentage
        $total = array_sum(array_column($marks_data, 'marks'));
        $percentage = $total / count($marks_data);

        echo json_encode([
            'marks_data' => $marks_data,
            'total' => $total,
            'percentage' => $percentage
        ]);
    } else {
        echo json_encode(['error' => 'No marks found for the given roll number.']);
    }

    $stmt->close();
}

$conn->close();
?>
