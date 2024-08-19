<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$error = '';
$show_error = false;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST["username"];
    $password = $_POST["password"];
        
    // Query to check if username and password match in the database
    $sql = "SELECT * FROM myadmin_table WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login successful
        session_start();
        $_SESSION["admin_username"] = $username;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        // Login failed
        $error = "Invalid username or password.";
        $show_error = true;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            text-align: center;
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
    <script>
        function startCountdown() {
            let countdown = 10;
            const countdownElement = document.getElementById('countdown');
            const interval = setInterval(() => {
                countdownElement.textContent = countdown;
                countdown--;
                if (countdown < 0) {
                    clearInterval(interval);
                    window.location.href = 'admin_login.html';
                }
            }, 1000);
        }
    </script>
</head>
<body>
    <div class="login-container">
      
        <?php if ($show_error): ?>
            <div class="error">
                <?php echo $error; ?>
                Redirecting in <span id="countdown">10</span> seconds...
                <script>startCountdown();</script>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
