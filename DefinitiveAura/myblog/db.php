<?php
$host = 'localhost';
$user = 'root';  // Usuário padrão do XAMPP
$password = 'admin';  // Senha vazia por padrão
$dbname = 'blog_db';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>