<?php
include('db.php');
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
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
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert Biblioteca -->
</head>

<body>

    <header>
        <div class="header">
            <div class="user-info">
                <?php if (isset($user_data)): ?>
                    <div class="user-profile">
                        <?php
                        $profile_image = !empty($user_data['profile_image']) ? htmlspecialchars($user_data['profile_image']) : 'uploads/default.jpg';
                        echo "<img height='40px' src='$profile_image' alt='Imagem de Perfil' class='userimagem'>";
                        echo "<span class='username'>" . htmlspecialchars($user_data['name']) . "</span>";
                        ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="logo-container">
                <img src="images/logobranca.png" alt="Logo Aura">
            </div>

            <div class="nav">
                <nav>
                    <a href="logout.php" class="logout-button" onclick="confirmarLogout(event);">SAIR</a> <!-- Botão de sair com confirmação -->
                    <a href="create_post.php">PUBLICAR POST</a>
                </nav>
            </div>
        </div>
    </header>

    <h1 class="h1Des">DESTAQUE DO DIA</h1>

    <div class="container">
        <section class="posts-section">
            <div class="main-post">
                <?php
                $sql_main = "SELECT posts.*, users.name, users.profile_image FROM posts
                             INNER JOIN users ON posts.user_id = users.id
                             WHERE posts.status='pending' ORDER BY posts.created_at DESC LIMIT 1";
                $result_main = $conn->query($sql_main);

                if ($result_main->num_rows > 0) {
                    $main_post = $result_main->fetch_assoc();
                    echo "<div class='main-post-item'>";
                    if (!empty($main_post['full_path'])) {
                        echo "<img src='" . htmlspecialchars($main_post['full_path']) . "' alt='Imagem do Post Principal'>";
                    }
                    echo "<h2><a href='post.php?id=" . $main_post['id'] . "'>" . htmlspecialchars($main_post['title']) . "</a></h2>";
                    echo "<p>Postado por: " . htmlspecialchars($main_post['name']) . "</p>";
                    echo "<p>" . substr(htmlspecialchars($main_post['content']), 0, 300) . "...</p>";
                    echo "</div>";
                }
                ?>
            </div>

            <h1 class="outherh1">OUTROS POSTS</h1>

          <!-- Parte do código onde você exibe os posts -->
<div class="other-posts">
    <?php
    $sql_query = $conn->query("
        SELECT posts.*, users.profile_image, users.name
        FROM posts
        INNER JOIN users ON posts.user_id = users.id
        WHERE posts.status='pending'
        ORDER BY posts.created_at DESC
        LIMIT 1, 20
    ");
    if ($sql_query->num_rows != 0) {
        while ($post = $sql_query->fetch_assoc()) {
            echo "<div class='post-item'>";
            echo "<div class='post-content'>";
            $profile_image_post = !empty($post['profile_image']) ? htmlspecialchars($post['profile_image']) : 'uploads/default.jpg';
            echo "<div class='post-user'>";
            echo "<img src='$profile_image_post' class='userimga' alt='Imagem do Usuário'>";
            echo "<span>" . htmlspecialchars($post['name']) . "</span>";
            
            // Adicionando a data do post
            $formatted_date = date("d/m/Y H:i", strtotime($post['created_at']));
            echo "<span class='post-date'> - $formatted_date</span>"; // Exibe a data do post ao lado do nome
            echo "</div>";
            echo "<h3><a class='aaa' href='post.php?id=" . $post['id'] . "'>" . htmlspecialchars($post['title']) . "</a></h3>";
            $description_line = explode("\n", htmlspecialchars($post['content']))[0];
            echo "<p class='post-description'>" . $description_line . "</p>";
            echo "</div>";
            echo "<img src='" . htmlspecialchars($post['full_path']) . "' class='post-item-img' alt='Imagem do Post'>";
            echo "</div>";
        }
    } else {
        echo "<p>Sem posts disponíveis.</p>";
    }
    ?>
</div>

    <?php include('includes/footer.php'); ?>

    <!-- Script de confirmação para logout -->
    <script>
        function confirmarLogout(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Você realmente deseja sair?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, sair',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "logout.php";
                }
            });
        }
    </script>
</body>

</html>
