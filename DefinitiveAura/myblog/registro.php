<?php
include('db.php');
session_start();

// Lógica de registro
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user'; // Define o papel como 'user' por padrão

    // Verifica se o e-mail já está registrado
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows == 0) {
        // Upload da imagem de perfil
        $profile_image = 'uploads/profile.png'; // Define a imagem padrão
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            $post_image = $_FILES['profile_image'];
            $pasta = "uploads/";
            $image_name = $post_image['name'];
            $new_image_name = uniqid(); // Gera um nome único para a imagem
            $extensao = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

            if (in_array($extensao, ["jpg", "png", "gif", "webp", "jfif", "jpeg"])) {
                $full_path = $pasta . $new_image_name . "." . $extensao;

                if (move_uploaded_file($post_image["tmp_name"], $full_path)) {
                    $profile_image = $full_path;
                } else {
                    echo "<p>Falha ao enviar arquivo</p>";
                }
            } else {
                echo "<p>Formato de arquivo não aceito</p>";
            }
        }

        // Inserção no banco de dados
        $query = "INSERT INTO users (name, email, password, role, profile_image) VALUES ('$name', '$email', '$password', '$role', '$profile_image')";
        
        if ($conn->query($query) === TRUE) {
            $last_id = $conn->insert_id;
            $_SESSION['user_id'] = $last_id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_role'] = $role;
            header("Location: login.php");
            exit();
        } else {
            echo "<p>Erro ao registrar usuário. Tente novamente.</p>";
        }
    } else {
        echo "<p>E-mail já registrado. Tente outro e-mail.</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css1/registro.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
    <title>Registro</title>
</head>
<body>
    <header class="header_registro">
        <div class="logos">
            <img src="images/logoazul.png" alt="Logo Aura" class="logo" width="150px">
        </div>
    </header>

    <div class="form-container">
        <div class="registro">
            <h1>Registrar-se</h1>
            <!-- Atualize o action para apontar para o arquivo correto -->
            <form action="registro.php" method="POST" enctype="multipart/form-data">
                <p>
                    <label>Nome</label>
                    <input type="text" name="name" placeholder="Nome completo" required>
                </p>
                <p>
                    <label>E-mail</label>
                    <input type="email" name="email" placeholder="@" required>
                </p>
                <p>
                    <label>Senha</label>
                    <input type="password" name="password" placeholder="Senha" required>
                </p>
                <p>
                    <label>Imagem de Perfil</label>
                    <input type="file" name="profile_image" accept="image/*">
                </p>
                <button type="submit" name="register" class="botao">Registrar</button>
                <p>Já tem uma conta? <a href="login.php">Entrar</a></p>
            </form>
        </div>
    </div>
</body>
</html>
