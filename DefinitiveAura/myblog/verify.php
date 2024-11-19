<?php
include('db.php');
session_start();

if (isset($_POST['verify'])) {
    $userId = $_SESSION['user_id'];
    $inputCode = $_POST['verification_code'];

    $query = "SELECT verification_code FROM users WHERE id='$userId'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['verification_code'] == $inputCode) {
            // Verificação concluída
            $updateQuery = "UPDATE users SET is_verified=1 WHERE id='$userId'";
            $conn->query($updateQuery);
            echo "<div class='success-message'>Conta verificada com sucesso!</div>";
            header("Location: login.php");
            exit();
        } else {
            echo "<div class='error-message'>Código de verificação incorreto.</div>";
        }
    } else {
        echo "<div class='error-message'>Usuário não encontrado.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de Conta</title>
    <link rel="stylesheet" href="css1/verify.css">
</head>
<body>
    <div class="container">
        <header>
            <img src="images/logoazul.png" alt="Logo Aura" class="logo">
        </header>
        <div class="verification-form">
            <h1>Verificação de Conta</h1>
            <p>Insira o código de verificação que foi enviado para o seu telefone ou email.</p>
            <form method="POST" action="verify.php">
                <label for="verification_code">Código de Verificação</label>
                <input type="text" id="verification_code" name="verification_code" placeholder="Ex: 123456" required>
                <button type="submit" name="verify" class="btn-verify">Verificar</button>
            </form>
        </div>
    </div>
</body>
</html>
