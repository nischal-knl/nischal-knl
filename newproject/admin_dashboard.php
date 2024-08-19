<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Management System</title>
   <link rel="stylesheet" type ="text/css" href="style/admin.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <img src="logo.png" alt="Logo" style="width: 100px; margin-bottom: 20px;">
            <h2>Manage Teachers</h2>
            <a href="add_teacher.php">Add Teacher</a>
            <a href="remove_teacher.php">Remove Teacher</a>
            <a href ="logout.php">Logout</a>
        </div>
        <div class="content">
            <h2 class="dashboard">Dashboard</h2>
            <div class="cards">
       
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
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch student count for each faculty
                $sql = "SELECT faculty, COUNT(*) AS student_count FROM students GROUP BY faculty";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="card" data-faculty="' . $row["faculty"] . '">';
                        echo '<h3>' . $row["faculty"] . '</h3>';
                        echo '<p>Students: ' . $row["student_count"] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "No students found.";
                }

                $conn->close();
                ?>
            </div>
            <div id="table-container">
      <!-- table will be rendered here -->
    </div>
        </div>
    </div>
  
    <div class="content">
  
   
 

    <script>
  // Add event listeners for card clicks
  const cards = document.querySelectorAll(".card");
  cards.forEach(card => {
    card.addEventListener("click", () => {
      const faculty = card.dataset.faculty;
      fetchStudents(faculty);
    });
  });

  // Function to fetch students using AJAX
  function fetchStudents(faculty) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_students.php?faculty=" + faculty, true);
    xhr.onload = function() {
      if (xhr.status === 200) {
        const response = xhr.responseText;
        const tableContainer = document.getElementById("table-container");
        tableContainer.innerHTML = response;
      }
    };
    xhr.send();
  }
</script>
</body>
</html>