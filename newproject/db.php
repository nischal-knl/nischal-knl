<?php

	$host = 'localhost';
	$user = 'root';
	$password = '';
	$database = 'student_db';
	$conn = mysqli_connect($host, $user, $password, $database);
	if (!$conn) {
		die('Could not connect: ' . mysqli_error($conn));
	}
	return $conn;

?>