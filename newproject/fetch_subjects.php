<?php
include 'db.php';

$faculty = $_GET['faculty'] ?? '';

if ($faculty) {
    $sql = "SELECT subject_id, subject_name FROM subjects WHERE faculty = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $faculty);
        $stmt->execute();
        $result = $stmt->get_result();

        $options = '';
        while ($row = $result->fetch_assoc()) {
            $subject_id = htmlspecialchars($row['subject_id']);
            $subject_name = htmlspecialchars($row['subject_name']);
            $options .= '<option value="' . $subject_id . '">' . $subject_name . '</option>';
        }

        $stmt->close();
    } else {
        // Error handling if the statement preparation fails
        $options = '<option value="">Error fetching subjects</option>';
    }

    $conn->close();
} else {
    // Error handling if faculty parameter is missing
    $options = '<option value="">No faculty specified</option>';
}

header('Content-Type: text/html; charset=UTF-8');
echo $options;
?>
