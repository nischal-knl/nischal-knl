<?php
session_start();
if (!isset($_SESSION['rollno']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Connect to database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "student_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if old password is correct
    $sql = "SELECT s_pass FROM students WHERE rollno = '" . $_SESSION['rollno'] . "'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $hashed_old_password = $row['s_pass'];

    if (md5($old_password) != $hashed_old_password) {
        $error = "Old password is incorrect";
    } else {
        // Check if new password and confirm password match
        if ($new_password != $confirm_password) {
            $error = "New password and confirm password do not match";
        } else {
            // Update password
            $hashed_new_password = md5($new_password);
            $sql = "UPDATE students SET s_pass = '" . $hashed_new_password . "' WHERE rollno = '" . $_SESSION['rollno'] . "'";
            $conn->query($sql);
            $success = "Password changed successfully";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        body {
            font-family: sans-serif;
        }
        .container {
            max-width: 300px;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            width: 90%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
        }
        .btn-submit {
            background-color: #6495ED;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background-color: #4169E1;
        }
        .error {
            color: #red;
            font-size: 12px;
            margin-bottom: 10px;
        }
        .success {
            color: #green;
            font-size: 12px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Change Password</h2>
        <?php if (isset($error)) { ?>
            <p class="error"><?= $error ?></p>
        <?php } elseif (isset($success)) { ?>
            <p class="success"><?= $success ?></p>
        <?php } ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="old_password">Old Password:</label>
            <input type="password" id="old_password" name="old_password" class="form-control" required>
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" class="form-control" required>
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            <button type="submit" name="submit" class="btn-submit">Change Password</button>
        </form>
    </div>
</body>
</html>