<?php
include('db.php');

// Lógica de registro
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Salvando imagem de perfil
    if ($_FILES['profile_image']['name']) {
        $profile_image = $_FILES['profile_image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_image);
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file);
    } else {
        $profile_image = 'default.png';
    }

    $query = "INSERT INTO users (name, email, password, profile_image) VALUES ('$name', '$email', '$password', '$profile_image')";
    
    if ($conn->query($query) === TRUE) {
        echo "<p>Cadastro realizado com sucesso!</p>";
    } else {
        echo "<p>Erro: " . $conn->error . "</p>";
    }
}

// Lógica de login
if (isset($_POST['login'])) {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo "<p>Bem-vindo, " . htmlspecialchars($user['name']) . "!</p>";
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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/registro.css">
    <title>Login e Registro</title>
</head>
<body>
    <header class="header_registro">
    <div class="logos">
        <img src="images/logo-aura.svg" alt="Logo Aura" class="logo" width="150px">
    </div>
    <button class="switch-button" id="toggleForm">Registrar-se</button>
</header>


<div class="form-container">
    <div id="forms">
        <!-- Formulário de Login -->
        <div class="login">
            <h1>Login</h1>
            <form action="login_registro.php" method="POST">
                <input type="email" name="login_email" placeholder="E-mail" required>
                <input type="password" name="login_password" placeholder="Senha" required>
                <button type="submit" name="login" class="botao">Entrar</button>
            </form>
        </div>

        <!-- Formulário de Registro -->
        <div class="register" style="display:none;">
            <h1>Registrar-se</h1>
            <form action="login_registro.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Nome" required>
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="password" placeholder="Senha" required>
                <input type="password" name="password_confirm" placeholder="Repita a senha" required>
                <input type="file" name="profile_image" accept="image/*">
                <button type="submit" name="register" class="botao">Registrar</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Alternar entre os formulários de Login e Registro
    const toggleForm = document.getElementById('toggleForm');
    const loginForm = document.querySelector('.login');
    const registerForm = document.querySelector('.register');

    toggleForm.addEventListener('click', function() {
        if (loginForm.style.display === 'none') {
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
            toggleForm.textContent = 'Registrar-se';
        } else {
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
            toggleForm.textContent = 'Entrar';
        }
    });
</script>


</body>
</html>
