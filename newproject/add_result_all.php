<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header('Location: teacher-login.php');
    exit;
}
include 'db.php';

$faculty = $_SESSION['faculty'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Results for All Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .result-card {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 600px;
            text-align: center;
        }

        .result-card h2 {
            margin-bottom: 20px;
        }

        .result-card table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .result-card th, .result-card td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .result-card th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .result-card input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .result-card button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .result-card button:hover {
            background-color: #0056b3;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="result-card">
        <h2>Add Results for All Students in Faculty: <?php echo htmlspecialchars($faculty); ?></h2>
        <form id="result-form">
            <label for="subject_id">Subject:</label>
            <select name="subject_id" id="subject_id">
                <!-- Options will be populated using AJAX -->
            </select><br><br>
            <table id="students-results-table">
                <thead>
                    <tr>
                        <th>Roll No</th>
                        <th>Name</th>
                        <th>Marks</th>
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
                        echo "<td><input type='text' name='marks[" . htmlspecialchars($row['rollno']) . "]' placeholder='Marks' required></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <button type="submit">Add Results</button>
        </form>
    </div>
    <script>
$(document).ready(function() {
    // Fetch subjects based on faculty
    $.ajax({
        url: 'fetch_subjects.php',
        type: 'GET',
        data: {faculty: '<?php echo $faculty; ?>'},
        success: function(data) {
            $('#subject_id').html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("Error fetching subjects: " + textStatus + ", " + errorThrown);
            console.log("Error fetching subjects: ", jqXHR.responseText);
        }
    });

    $('#result-form').on('submit', function(e) {
        e.preventDefault();

        // Client-side validation
        var valid = true;
        $('input[name^="marks"]').each(function() {
            var mark = $(this).val();
            if (isNaN(mark) || mark < 0 || mark > 100) {
                valid = false;
                alert("Invalid mark for roll number: " + $(this).closest('tr').find('td:first').text() + ". Please enter a value between 0 and 100.");
                return false;
            }
        });

        if (!valid) {
            return;
        }

        $.ajax({
            url: 'insert_result_all.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert(response); // Debug alert to check if the request was successful
                console.log("Success response: ", response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Error adding results: " + textStatus + ", " + errorThrown);
                console.log("Error adding results: ", jqXHR.responseText);
            }
        });
    });
});
</script>


</body>
</html>
