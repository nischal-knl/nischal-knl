<?php
include 'db.php';

$roll_no = $_GET['roll_no'];

// Prepare the SQL query
$query = "SELECT m.subject_id, s.subject_name, m.marks 
          FROM Marks m 
          JOIN Subjects s ON m.subject_id = s.subject_id 
          WHERE m.rollno = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

// Bind parameters
$stmt->bind_param("i", $roll_no);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

$rows = '';
while ($row = $result->fetch_assoc()) {
    $rows .= '<tr>
                <td>' . htmlspecialchars($row['subject_id']) . '</td>
                <td>' . htmlspecialchars($row['subject_name']) . '</td>
                <td>' . htmlspecialchars($row['marks']) . '</td>
              </tr>';
}

echo $rows;
?>
