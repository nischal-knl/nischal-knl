<?php
session_start();
if (!isset($_SESSION['rollno']) || !isset($_SESSION['username'])) {
    header("Location: stud_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Result Display</title>
    <link rel="stylesheet" type="text/css" href="style/stu_styles.css">
</head>
<body>
    <div class="top-menu">
        <img src="logo.png" alt="Logo" class="logo">
        <span class="welcome-message">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <div class="menu-links">
            <a href="change_password.php">Change Password</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <div class="container">
    <div class="card">
    <h1>View My Result</h1>
    <button type="button" onclick="viewResult()">View Result</button>
    <div id="result"></div><br>
    <button id="request-update" style="display:none;" onclick="requestUpdate()">Request Update</button>
</div>
    
        
        <script>
            document.getElementById("result").style.display = "none"; // Add this line to hide the element initially

function viewResult() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "fetch_marks.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.error) {
                document.getElementById("result").innerHTML = response.error;
                document.getElementById("request-update").style.display = "none";
            } else {
                var marks_data = response.marks_data;
                var resultHtml = '';
                for (var i = 0; i < marks_data.length; i++) {
                    resultHtml += `<p>${marks_data[i].subject_name}: ${marks_data[i].marks}</p>`;
                }
                resultHtml += `<p>Total: ${response.total}</p>`;
                resultHtml += `<p>Percentage: ${response.percentage}%</p>`;
                document.getElementById("result").innerHTML = resultHtml;
                document.getElementById("result").style.display = "block"; // Add this line to show the element
                document.getElementById("request-update").style.display = "block";
            }
        }
    };
    var rollno = "<?php echo $_SESSION['rollno'];?>";
    xhr.send("roll_no=" + rollno);
}
              function requestUpdate() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "send_update_request.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert("Update request sent!");
                }
            };
            xhr.send();
        }
    </script>
    
</body>
</html>