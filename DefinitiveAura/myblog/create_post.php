<?php
include('db.php');
session_start();

if (isset($_POST['create_post'])) {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category']; // Obtém a categoria escolhida pelo usuário

    // Verifica se uma imagem foi enviada
    if (isset($_FILES['post_image'])) {
        $post_image = $_FILES['post_image'];
        if ($post_image['error']) {
            die("Falha ao enviar o arquivo");
        }

        $pasta = "uploads/";
        $image_name = $post_image['name'];
        $new_image_name = uniqid();
        $extensao = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        if (!in_array($extensao, ["jpg", "png", "gif", "webp", "jfif"])) {
            die("Formato de arquivo não aceito");
        }

        $full_path = $pasta . $new_image_name . "." . $extensao;
        $deu_certo = move_uploaded_file($post_image["tmp_name"], $full_path);

        $query = "INSERT INTO posts (user_id, title, content, category, full_path, status, nome, formato) 
              VALUES ('$user_id', '$title', '$content', '$category', '$full_path', 'pending', '$new_image_name', '$extensao')";

        if ($conn->query($query) === TRUE) {
            echo "<p>Post criado com sucesso! Aguarde a aprovação do administrador.</p>";
        } else {
            echo "<p>Erro ao criar o post: " . $conn->error . "</p>";
        }

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
    <link rel="stylesheet" href="css1/createPost.css">
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

            <label for="category">Categoria</label>
            <select id="category" name="category" required>
                <option value="Curiosidade">Curiosidade</option>
                <option value="Novidade">Novidade</option>
                <option value="Dúvida">Dúvida</option>
                <option value="Automação">Automação</option>
            </select>

            <input type="file" name="post_image">

            <button type="submit" name="create_post" class="botao">Criar Post</button>
        </form>
    </div>
</body>

</html>