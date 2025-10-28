<?php

// Database connection details
$servername = '127.0.0.1';
$username = 'root';
$password = '';
$dbname = 'goldbank'; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Optional: you can remove the echo statement for production to avoid showing "Connected successfully" on the page
// echo "Connected successfully";

?>