<?php
include('db.php');
session_start();

// Verifica se o formulário foi enviado
if (isset($_POST['create_post'])) {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Verifica se uma imagem foi enviada
    if (isset($_FILES['post_image'])) {
        $post_image = $_FILES['post_image'];

        // Verifica se houve algum erro no envio da imagem
        if ($post_image['error']) {
            die("Falha ao enviar o arquivo");
        }

        // Define a pasta onde a imagem será salva
        $pasta = "uploads/";
        $image_name = $post_image['name'];
        $new_image_name = uniqid(); // Gera um nome único para a imagem
        $extensao = strtolower(pathinfo($image_name, PATHINFO_EXTENSION)); // Obtém a extensão da imagem

        // Verifica se a extensão é válida
        if ($extensao != "jpg" && $extensao != "png" && $extensao != "gif" && $extensao != "webp" && $extensao != "jfif") {
            die("Formato de arquivo não aceito");
        }

        // Define o caminho completo da imagem
        $full_path = $pasta . $new_image_name . "." . $extensao;

        // Move o arquivo enviado para a pasta de destino
        $deu_certo = move_uploaded_file($post_image["tmp_name"], $full_path);

        // Insere o post no banco de dados com status 'pending'
        $query = "INSERT INTO posts (user_id, title, content, full_path, status, nome, formato) 
                  VALUES ('$user_id', '$title', '$content', '$full_path', 'pending', '$new_image_name', '$extensao')";

        if ($conn->query($query) === TRUE) {
            echo "<p>Post criado com sucesso! Aguarde a aprovação do administrador.</p>";
        } else {
            echo "<p>Erro ao criar o post: " . $conn->error . "</p>";
        }

        // Verifica se o upload foi bem-sucedido
        if ($deu_certo) {
            echo  "<p>Deu certo! <a target=\"_blank\" href=\"$full_path\">Ver imagem</a></p>";
        } else {
            echo "<p>Falha ao enviar arquivo</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Post</title>
    <link rel="stylesheet" href="css/createPost.css">
</head>
<body>
    <header>
        <div class="logos">
            <img src="images/logobranca.png" alt="Logo Aura" class="logo">
        </div>
    </header>

    <div class="form-container">
        <form action="create_post.php" method="POST" enctype="multipart/form-data">
            <label for="title">Título</label>
            <input type="text" id="title" name="title" placeholder="Digite o título do post" required>

            <label for="content">Conteúdo</label>
            <textarea id="content" name="content" rows="5" placeholder="Escreva o conteúdo do post" required></textarea>

            <input type="file" name="post_image">

            <button type="submit" name="create_post" class="botao">Criar Post</button>
        </form>
    </div>
</body>
</html>
