<?php
session_start();
include 'db.php'; // Make sure you have a file to handle the DB connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teacher_id = $_POST['teacher_id'];
    $faculty = $_POST['faculty'];
    $password = $_POST['password'];

    // Fetch the hashed password from the database
    $query = "SELECT t_pass FROM teacher_table WHERE t_id = ? AND t_faculty = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $teacher_id, $faculty);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verify the provided password against the hashed password
    if (password_verify($password, $hashed_password)) {
        $_SESSION['teacher_id'] = $teacher_id;
        $_SESSION['faculty'] = $faculty;
        header('Location: teacher_dashboard.php');
        exit;
    } else {
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .login-card {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }

        .login-card h2 {
            margin-bottom: 20px;
        }

        .login-card input {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-card button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-card button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Teacher Login</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="teacher_id" placeholder="Teacher ID" required>
            <input type="password" name="password" placeholder="Password" required>
            <label for="faculty">Faculty:</label>
            <select id="faculty" name="faculty" required>
                <option value="">Select Faculty</option>
                <option value="Science">Science</option>
                <option value="Arts">Arts</option>
                <option value="Engineering">Engineering</option>
            </select><br><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
