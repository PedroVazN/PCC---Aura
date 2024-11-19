<?php
include('db.php');

// Já garantido que a sessão está ativa, não precisa do session_start() aqui.
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT curso FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();

    // Verifica se o usuário é do curso de Mecânica
    if ($user_data['curso'] != 'mecanica') {
        header("Location: acesso_negado.php");
        exit();
    }
}
?>

<?php include('includes/header.php'); ?> <!-- Inclusão do header -->

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Área Exclusiva Mecânica</title>
    <link rel="stylesheet" href="css1/home1.css">
</head>
<body>
    <h1>Bem-vindo à área exclusiva de Mecânica!</h1>
    <!-- Conteúdo específico para alunos e professores de Mecânica -->
</body>
</html>

<?php include('includes/footer.php'); ?> <!-- Inclusão do footer -->
