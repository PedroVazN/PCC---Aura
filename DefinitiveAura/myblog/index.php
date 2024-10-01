<?php
include('db.php');
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fórum Aura</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header class="header">
        <div class="logo-container">
            <img src="images/logoa.png" alt="Logo Aura">
        </div>
        <nav class="header-nav">
            <a href="login.php">Login</a>
            <a href="create_post.php">Criar Post</a>
            <?php
            // Verifica se o usuário está logado
            if (isset($_SESSION['id'])) {
                $user_id = $_SESSION['id'];

                // Busca a imagem do perfil do usuário no banco de dados
                $query = $conn->query("SELECT profile_image FROM users WHERE id = $user_id");

                // Verifica se a consulta retornou resultados
                if ($query && $query->num_rows > 0) {
                    $user = $query->fetch_assoc();
                    $profile_image = !empty($user['profile_image']) ? $user['profile_image'] : 'default.jpg';

                    // Exibe a imagem do perfil
                    echo "<img src='uploads/$profile_image' class='userimg' alt='Imagem do Usuário' height='100'>";
                } else {
                    // Exibe uma imagem padrão se não encontrar a imagem do perfil
                    echo "<img src='uploads/default.jpg' class='userimg' alt='Imagem Padrão' height='100'>";
                }
            }
            ?>
        </nav>
    </header>

    <div class="container">
        <div class="search-bar">
            <input type="text" placeholder="Pesquisar no fórum...">
        </div>

        <!-- Lista de posts -->
        <section class="other-posts">
            <div class="post-list">
                <?php
                // Seleciona os posts e suas informações de usuário
                $sql_query = $conn->query("
                    SELECT posts.*, users.profile_image, users.name 
                    FROM posts 
                    INNER JOIN users ON posts.user_id = users.id 
                    WHERE posts.status='pending' 
                    ORDER BY posts.created_at DESC
                ");

                if ($sql_query->num_rows != 0) {
                    while ($post = $sql_query->fetch_assoc()) {
                        echo "<div class='post-item'>";

                        // Exibe a imagem de perfil do usuário
                        if (!empty($post['profile_image'])) {
                            echo "<img src='" . $post['profile_image'] . "' class='userimg' alt='Imagem do Usuário'>";
                        } else {
                            echo "<img src='uploads/default.jpg' alt='Imagem Padrão' class='userimg'>";
                        }

                        echo "<div class='post-content'>";
                        echo "<h3><a href='post.php?id=" . $post['id'] . "'>" . htmlspecialchars($post['title']) . "</a></h3>";
                        echo "<p>Postado por: " . htmlspecialchars($post['name']) . "</p>";
                        echo "<p>" . substr(htmlspecialchars($post['content']), 0, 150) . "...</p>";
                        echo "</div>";

                        if (!empty($post['full_path'])) {
                            echo "<img src='" . $post['full_path'] . "' class='imgpost' alt='Imagem do Post'>";
                        }

                        echo "</div>";
                    }
                } else {
                    echo "<p>Sem posts disponíveis.</p>";
                }
                ?>
            </div>
        </section>
    </div>

    <?php include('includes/footer.php'); ?>
</body>

</html>
