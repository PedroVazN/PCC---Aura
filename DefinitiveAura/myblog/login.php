<?php
include('db.php');
session_start();

// Verifique o login do usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['login_email'];  // Altere para 'login_email' de acordo com o campo no HTML
    $password = $_POST['login_password'];  // Altere para 'login_password'

    // Verifique se o usuário é o admin
    if ($email == 'admin@admin' && $password == 'adminsupremokk') {
        // Se for o admin, redirecione para a página de admin
        $_SESSION['user_id'] = 0;  // Você pode atribuir um ID fictício para o admin
        $_SESSION['user_role'] = 'admin';  // Defina o papel como 'admin'
        $_SESSION['user_name'] = 'Administrador';  // Nome do admin
        header("Location: admin_panel.php");  // Redireciona para o painel de admin
        exit();
    }

    // Se não for admin, verifique as credenciais no banco de dados
    $sql = "SELECT id, name, role, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verifique a senha
        if (password_verify($password, $user['password'])) {
            // Salve as informações do usuário na sessão
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];  // Salva a função do usuário na sessão
            $_SESSION['user_name'] = $user['name'];

            // Redirecione para a página principal ou o fórum
            header("Location: forum.php");
            exit();
        } else {
            $error_message = "Senha incorreta.";
        }
    } else {
        $error_message = "Usuário não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css1/login.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
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
