<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rollno = $_POST["rollno"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Fetch the password from the database
    $query = "SELECT s_pass FROM students WHERE rollno = ? AND username = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ss", $rollno, $username);
        $stmt->execute();
        $stmt->bind_result($stored_password);
        $stmt->fetch();
        $stmt->close();

        // Verify the provided password against the stored password hash
        if (md5($password) == $stored_password) {
            $_SESSION['rollno'] = $rollno;
            $_SESSION['username'] = $username;
            // Login successful, redirect to dashboard
            header("Location: stu_dashboard.php");
            exit;
        } else {
            $error = "Invalid credentials";
        }
    } else {
        $error = "Database query failed";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="stu_login.css">
</head>
<body>
    <div class="login">
        <h2 class="h2">Student Login</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form id="login-form" method="POST">
            <label for="rollno">Roll No:</label>
            <input type="text" id="rollno" name="rollno" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Login">

            <p>Don't have an account? <a href="student_signup.html">Sign up</a></p>
        </form>
    </div>

    <script>
        function validateForm() {
            var rollno = document.getElementById("rollno").value;
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;

            if (rollno === "" || username === "" || password === "") {
                var errorDiv = document.getElementById("error");
                if (!errorDiv) {
                    errorDiv = document.createElement("div");
                    errorDiv.id = "error";
                    errorDiv.className = "error";
                    document.querySelector(".login").insertBefore(errorDiv, document.getElementById("login-form"));
                }
                errorDiv.innerHTML = "Please fill in all fields";
                return false;
            }

            document.getElementById("login-form").submit();
        }
    </script>
</body>
</html>
