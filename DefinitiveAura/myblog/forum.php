<?php
include('db.php');
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    // Consulta direta
    $sql = "SELECT profile_image, name FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();
}

$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fórum Aura</title>
    <link rel="stylesheet" href="css1/style.css">
<<<<<<< HEAD
      <link rel="icon" type="image/png" href="images/favicon.png">
=======
>>>>>>> 9a48be218305e63711b9c157232963c994d332cc
    <link rel="stylesheet" href="css1/footer.css">
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header class="header">
        <div class="user-info">
            <?php if (isset($user_data)): ?>
                <div class="user-profile">
                    <img height='40px' src="<?= htmlspecialchars($user_data['profile_image'] ?: 'uploads/default.jpg') ?>" alt='Imagem de Perfil'>
                    <span class="username"><?= htmlspecialchars($user_data['name']) ?></span>
                </div>
            <?php endif; ?>
        </div>
        <div class="logo-container">
            <a href="index.php">
                <img src="images/logobranca.png" alt="Logo Aura">
            </a>
        </div>
        <nav class="nav">
            <a href="logout.php" class="logout-button" onclick="confirmarLogout(event);">SAIR</a>
            <a href="create_post.php">PUBLICAR POST</a>
        </nav>
    </header>

    <main class="main-content">
        <h1 class="h1Des">DESTAQUE DO DIA</h1>
        <div class="category-filter">
            <a href="forum.php">Todos</a>
            <a href="forum.php?category=Curiosidade">Curiosidade</a>
            <a href="forum.php?category=Novidade">Novidade</a>
            <a href="forum.php?category=Dúvida">Dúvida</a>
            <a href="forum.php?category=Automação">Automação</a>
        </div>

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
            <div class="other-posts">
                <?php
                $sql_query = "SELECT posts.*, users.profile_image, users.name FROM posts
                              INNER JOIN users ON posts.user_id = users.id
                              WHERE posts.status='pending'";
                if ($category_filter) {
                    $sql_query .= " AND posts.category = '" . $conn->real_escape_string($category_filter) . "'";
                }
                $sql_query .= " ORDER BY posts.created_at DESC LIMIT 20";

                $result = $conn->query($sql_query);

                if ($result->num_rows > 0) {
                    while ($post = $result->fetch_assoc()) {
                        echo "<div class='post-item'>";
                        echo "<div class='post-content'>";
                        echo "<div class='post-user'>";
                        echo "<img src='" . htmlspecialchars($post['profile_image'] ?: 'uploads/default.jpg') . "' class='userimga' alt='Imagem do Usuário'>";
                        echo "<span>" . htmlspecialchars($post['name']) . "</span>";
                        $formatted_date = date("d/m/Y H:i", strtotime($post['created_at']));
                        echo "<span class='post-date'> - $formatted_date</span>";
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
        </section>
    </main>

    <?php include('includes/footer.php'); ?>

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
