<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Remove Teacher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header img {
            height: 120px;
        }
        .header h1 {
            margin: 0;
            flex-grow: 1;
            text-align: center;
        }
        .form-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        form {
            display: flex;
            align-items: center;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        label {
            margin-right: 10px;
        }
        input[type="text"] {
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 8px 12px;
            border: none;
            background-color: #6495ED;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0000FF;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="logo.png" alt="Logo">
        <h1>Remove Teacher</h1>
    </div>
    <div class="form-container">
        <form id="removeTeacherForm">
            <label for="t_id">Teacher ID:</label>
            <input type="text" id="t_id" name="t_id" required>
            <button type="submit">Remove Teacher</button>
        </form>
    </div>
    <div id="error" class="error"></div>
    <table id="teacherTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Faculty</th>
            </tr>
        </thead>
        <tbody>
            <!-- Teacher list will be loaded here -->
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Load teacher list on page load
            loadTeacherList();
            
            // Handle form submission
            document.getElementById('removeTeacherForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const t_id = document.getElementById('t_id').value;
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'remove_teacher_ajax.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        if (xhr.responseText.trim() === 'success') {
                            loadTeacherList();
                            document.getElementById('error').textContent = '';
                        } else {
                            document.getElementById('error').textContent = 'Teacher does not exist.';
                        }
                    }
                };
                xhr.send('t_id=' + encodeURIComponent(t_id));
            });
            
            // Function to load teacher list
            function loadTeacherList() {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'get_teacher.php', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        document.querySelector('#teacherTable tbody').innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            }
        });
    </script>
</body>
</html>
