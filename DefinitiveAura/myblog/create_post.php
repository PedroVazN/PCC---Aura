<?php include('db.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Post</title>
    <link rel="stylesheet" href="css/createPost.css">
</head>
<body>

    <?php include('includes/header_create_post.php'); ?>

    <div class="container">
        <span class="Title"><h1>Criar um novo post</h1></span>
        <div class="form">
        <form action="create_post.php" method="POST" enctype="multipart/form-data">
            <label for="title">Título:</label>
            <input type="text" name="title" required>

            <label for="content">Conteúdo:</label>
            <textarea name="content" rows="10" required></textarea>

            <div class="upload-container">
                <label for="image">Imagem:</label>
                <input type="file" name="image" accept="image/*">
            </div>

            <button type="submit" name="submit">Criar Post</button>
        </form>
        </div>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        // Para o upload da imagem, você pode adicionar lógica aqui, se necessário

        $query = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
        if ($conn->query($query) === TRUE) {
            echo "<p>Post criado com sucesso!</p>";
        } else {
            echo "<p>Erro: " . $conn->error . "</p>";
        }
    }
    ?>

    <footer>
        <p>© 2024 Seu Nome ou Empresa. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
