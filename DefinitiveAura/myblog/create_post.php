<?php
include('db.php');
session_start();

// Lógica de criação de posts
if (isset($_POST['create_post'])) {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    

    // Upload da imagem
    if (isset($_FILES['post_image'])) {
        $post_image = $_FILES['post_image'];
        
        if ($post_image['error']) {
            die("Falha ao enviar o arquivo");
        }

        $pasta = "uploads/";
        $image_name = $post_image['name'];
        $new_image_name = uniqid();
        $extensao = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        if ($extensao != "jpg" && $extensao != "png" && $extensao != "gif" && $extensao != "webp") {
            die("Formato de arquivo não aceito");
        }

        // Caminho completo para armazenar no banco de dados
        $full_path = $pasta . $new_image_name . "." . $extensao;

        $deu_certo = move_uploaded_file($post_image["tmp_name"], $full_path);

        if ($deu_certo) {
            echo "<p>Deu certo! <a target=\"_blank\" href=\"$full_path\">Ver imagem</a></p>";
        } else {
            echo "<p>Falha ao enviar arquivo</p>";
        }

    } else {
        $full_path = null;
    }

    // Insere o post com status 'pending' por padrão
    $query = "INSERT INTO posts (user_id, title, content, full_path, status, nome, formato) VALUES ('$user_id', '$title', '$content', '$full_path', 'pending', '$new_image_name', '$extensao')";

    if ($conn->query($query) === TRUE) {
        echo "<p>Post criado com sucesso! Aguarde a aprovação do administrador.</p>";
    } else {
        echo "<p>Erro ao criar o post: " . $conn->error . "</p>";
    }
}

// Corrigindo o uso da variável de conexão
$sql_query = $conn->query("SELECT * FROM posts");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Post</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Criar um Novo Post</h1>
    </header>

    <div class="form-container">
        <form action="create_post.php" method="POST" enctype="multipart/form-data">

            <input type="text" id="title" name="title" placeholder="Digite o título do post" required>

            <textarea id="content" name="content" rows="5" placeholder="Escreva o conteúdo do post" required></textarea>

            <input type="file" name="post_image">

            <button type="submit" name="create_post" class="botao">Criar Post</button>
        </form>

        <table>
            <thead>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Data de Criação</th>
            </thead>
            <tbody>
                <?php 
                while ($post = $sql_query->fetch_assoc()) {
                ?>
                <tr>
                    <!-- Exibe a imagem com o caminho completo -->
                    <td><img height="100" src="<?php echo $post['full_path']; ?>" alt="Imagem do post"></td>

                    <!-- Exibe o nome da imagem e link para visualizá-la -->
                    <td><a target="_blank" href="<?php echo $post['full_path']; ?>"><?php echo $post['full_path']; ?></a></td>

                    <!-- Exibe a data formatada -->
                    <td><?php echo date("d/m/Y H:i", strtotime($post['created_at'])); ?></td>
                </tr>
                <?php 
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
