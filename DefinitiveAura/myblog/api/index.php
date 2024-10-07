<?php
include('db.php');
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    // Consulta para pegar a imagem de perfil e o nome do usuário logado
    $sql = "SELECT profile_image, name FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
}
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
            <?php if (isset($user_data)): ?>
                <div class="user-profile">
                    <?php
                    // Exibe a imagem de perfil do usuário logado, utilizando o mesmo padrão que nos posts
                    $profile_image = !empty($user_data['profile_image']) ? htmlspecialchars($user_data['profile_image']) : 'uploads/default.jpg';
                    echo "<img height='40px' src='$profile_image' alt='Imagem de Perfil' class='userimagem'>";
                    ?>
                    <span>Bem-vindo, <?php echo htmlspecialchars($user_data['name']); ?></span>
                </div>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
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

                        // Exibe a imagem de perfil do usuário que criou o post
                        $profile_image_post = !empty($post['profile_image']) ? htmlspecialchars($post['profile_image']) : 'uploads/default.jpg';
                        echo "<img src='$profile_image_post' class='userimg' alt='Imagem do Usuário'>";

                        echo "<div class='post-content'>";
                        echo "<h3><a href='post.php?id=" . $post['id'] . "'>" . htmlspecialchars($post['title']) . "</a></h3>";
                        echo "<p>Postado por: " . htmlspecialchars($post['name']) . "</p>";
                        echo "<p>" . substr(htmlspecialchars($post['content']), 0, 150) . "...</p>";
                        echo "</div>";

                        // Exibe a imagem do post (se houver)
                        if (!empty($post['full_path'])) {
                            echo "<img src='" . htmlspecialchars($post['full_path']) . "' class='imgpost' alt='Imagem do Post'>";
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
