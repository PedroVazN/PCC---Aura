<?php 
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM users WHERE id='$user_id'";
$user_result = $conn->query($user_query);
$user = $user_result->fetch_assoc();

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $profile_image = $user['profile_image'];
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $pasta = "uploads/";
        $image_name = $_FILES['profile_image']['name'];
        $new_image_name = uniqid() . "." . strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $full_path = $pasta . $new_image_name;
        
        if (move_uploaded_file($_FILES['profile_image']["tmp_name"], $full_path)) {
            $profile_image = $full_path;
        }
    }

    $update_query = "UPDATE users SET name='$name', email='$email', profile_image='$profile_image' WHERE id='$user_id'";
    if ($conn->query($update_query)) {
        $_SESSION['user_name'] = $name;
        header("Location: configuracao.php?success=1");
    } else {
        echo "<p>Erro ao atualizar perfil. Tente novamente.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css1/configuracao.css">
    <title>Configuração do Usuário</title>
</head>
<body>
    <div class="container">
        <h1>Configurações de Perfil</h1>
        <form action="configuracao.php" method="POST" enctype="multipart/form-data">
            <div class="profile-pic">
                <img src="<?php echo $user['profile_image']; ?>" alt="Foto de perfil">
                <input type="file" name="profile_image" accept="image/*">
            </div>
            <label>Nome</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
            <label>E-mail</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
            <button type="submit" name="update">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
