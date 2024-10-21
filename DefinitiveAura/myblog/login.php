<?php
include('db.php');
session_start();

// Lógica de login
if (isset($_POST['login'])) {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            // Verifica se o usuário é administrador ou comum
            if ($user['role'] == 'admin') {
                header("Location: admin_panel.php"); // Redireciona o admin para o painel de aprovação
            } else {
                header("Location: index.php"); // Usuário comum é redirecionado para a página inicial
            }
            exit();
        } else {
            echo "<p>Senha incorreta.</p>";
        }
    } else {
        echo "<p>Usuário não encontrado.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
<header class="header_registro">
        <div class="logos">
            <img src="images/logoazul.png" alt="Logo Aura" class="logo" width="150px">
        </div>
    </header>

    <div class="form-container">
        <div class="login">
            <h1>Login</h1>
            <form action="login.php" method="POST">
                <p>
                    <label>E-mail</label>
                    <input type="email" name="login_email" placeholder="@" required>
                </p>
                <p>
                    <label>Senha</label>
                    <input type="password" name="login_password" placeholder="Senha" required>
                </p>
                <button type="submit" name="login" class="botao">Entrar</button>
                <p>Não tem uma conta? <a href="registro.php">Registrar</a></p>
            </form>
        </div>
    </div>
</body>
</html>
