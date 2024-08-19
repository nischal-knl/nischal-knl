<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: ". $conn->connect_error);
}

// Fetch teachers from database
$sql = "SELECT t_id, t_name, t_faculty FROM teacher_table";
$result = $conn->query($sql);

$teachers = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $teachers[] = $row;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Teacher</title>
  <style>
    body {
      font-family: sans-serif;
    }
   .container {
      display: flex;
      flex-direction: row;
    }
	.logo {
  width: 100%; /* make the logo full width */
  height: 100px; /* adjust the height to your liking */
  margin-bottom: 20px; /* add some space between the logo and the h2 */
  object-fit: contain; /* make sure the logo doesn't get distorted */
}
   .sidebar {
      width: 200px;
      background-color: #8988CE;
      padding: 20px;
    }
   
   
	.sidebar {
  height: 100vh; /* make the sidebar full height */
  padding-bottom: 20px; /* add some padding at the bottom */
}

.sidebar h2 {
  margin-bottom: 20px;
}

.form-container {
  display: flex;
  justify-content: center; /* center the form horizontally */
  padding: 20px;
}

.form-control {
  width: 100%;
  padding: 10px;
  margin-bottom: 20px;
}

.btn-submit {
  background-color: #6495ED; /* make the submit button blue */
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.btn-submit:hover {
  background-color: #0000FF;
}

  </style>
</head>
<body>
	
<div class="container">
  <div class="sidebar">
  <img src="logo.png" alt="Logo" class="logo">
  <h3>Registered Teachers</h3>
      <ul id="teacher-list">
        <?php foreach ($teachers as $teacher) {?>
          <li><?= $teacher["t_name"]?> (<?= $teacher["t_faculty"]?>)</li><br>
        <?php }?>
      </ul>
  </div>
  
  <div class="form-container">
    <form id="add-teacher-form">
      <label for="teacher-id">Teacher ID:</label>
      <input type="text" id="teacher-id" class="form-control" required>
      <label for="teacher-name">Teacher Name:</label>
      <input type="text" id="teacher-name" class="form-control" required>
      <label for="teacher-password">Teacher Password:</label>
      <input type="password" id="teacher-password" class="form-control" required>
      <label for="faculty">Faculty:</label>
      <select id="faculty" class="form-control" required>
        <option value="">Select Faculty</option>
        <option value="Science">Science</option>
        <option value="Arts">Arts</option>
        <option value="Engineering">Engineering</option>
      </select>
      <button class="btn-submit" id="submit-btn">Add Teacher</button>
    </form>
  </div>
</div>
  

<script>
  const form = document.getElementById("add-teacher-form");
  const submitBtn = document.getElementById("submit-btn");
  const teacherList = document.getElementById("teacher-list");

  form.addEventListener("submit", (e) => {
    e.preventDefault();
    const teacherId = document.getElementById("teacher-id").value;
    const teacherName = document.getElementById("teacher-name").value;
    const teacherPassword = document.getElementById("teacher-password").value;
    const faculty = document.getElementById("faculty").value;

    if (teacherId && teacherName && teacherPassword && faculty) {
      if (parseInt(teacherId) <= 0) {
        alert("Teacher ID cannot be less than 1!");
        return;
      }

      fetch("add_teacher_process.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `t_id=${teacherId}&t_name=${teacherName}&t_pass=${teacherPassword}&t_faculty=${faculty}`
      })
      .then(response => response.text())
      .then((data) => {
        const teacherHTML = `<li>${teacherName} (${faculty})</li>`;
        teacherList.innerHTML += teacherHTML;
        form.reset();
      })
      .catch((error) => {
        console.error(error);
      });
    } else {
      alert("Please fill in all fields!");
    }
  });
</script>
</body>
</html>