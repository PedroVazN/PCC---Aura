<?php
$host = 'localhost';
$user = 'root';  
$password = 'admin';  
$dbname = 'blog_db';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 5";
$result = mysqli_query($conn, $query);
 
?>