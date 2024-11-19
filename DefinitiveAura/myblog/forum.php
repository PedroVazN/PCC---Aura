<?php 
include('db.php');
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    // Consulta direta para obter os dados do usuário
    $sql = "SELECT profile_image, name, curso, role FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();
}

// Função para definir a cor do curso
function getPostColor($curso)
{
    switch ($curso) {
        case 'ads':
            return '#800080'; // Roxo
        case 'mecanica':
            return '#1E90FF'; // Azul
        case 'eletronica':
            return '#FF6347'; // Vermelho
        default:
            return '#1E90FF'; // Cor padrão
    }
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
    <link rel="icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" href="css1/footer.css">
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <header class="header">
        <div class="user-info">
            <?php if (isset($user_data)): ?>
                <div class="user-profile" style="border-color: <?= getPostColor($user_data['curso']); ?>;">
                    <img height='40px' src="<?= htmlspecialchars($user_data['profile_image'] ?: 'uploads/default.jpg') ?>" alt='Imagem de Perfil' style="border: 2px solid <?= getPostColor($user_data['curso']); ?>;">
                    <span class="username" style="color: white; font-weight: bold;"><?= htmlspecialchars($user_data['name']) ?></span>
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
                // Modificando a consulta para exibir posts com status 'pending' ou 'approved'
                $status_condition = (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') ? "IN ('pending', 'approved')" : "= 'approved'"; // Verifica se o usuário está logado e se é admin
                
                $sql_query = "SELECT posts.*, users.profile_image, users.name, users.role, users.curso FROM posts
                              INNER JOIN users ON posts.user_id = users.id
                              WHERE posts.status $status_condition";
                if ($category_filter) {
                    $sql_query .= " AND posts.category = '" . $conn->real_escape_string($category_filter) . "'";
                }
                $sql_query .= " ORDER BY posts.created_at DESC LIMIT 1";

                $result = $conn->query($sql_query);

                if ($result->num_rows > 0) {
                    while ($post = $result->fetch_assoc()) {
                        $post_class = ($post['role'] == 'professor') ? 'post-item professor-post' : 'post-item';

                        echo "<div class='$post_class'>";
                        echo "<div class='post-content'>";
                        echo "<div class='post-user'>";
                        echo "<img src='" . htmlspecialchars($post['profile_image'] ?: 'uploads/default.jpg') . "' class='userimga' alt='Imagem do Usuário'>";
                        echo "<span style='color: " . getPostColor($post['curso']) . "; font-weight: bold;'>" . htmlspecialchars($post['name']) . "</span>";
                        $formatted_date = date("d/m/Y H:i", strtotime($post['created_at']));
                        echo "<span class='post-date'> - $formatted_date</span>";
                        echo "</div>";

                        $post_color = ($post['role'] == 'professor') ? '#FF0000' : getPostColor($post['curso']);
                        echo "<h3><a class='aaa' href='post.php?id=" . $post['id'] . "' style='color: $post_color;'>" . htmlspecialchars($post['title']) . "</a></h3>";

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

            <div class="other-posts">
                <?php
                // Modificando a consulta para exibir posts com status 'pending' ou 'approved'
                $sql_query = "SELECT posts.*, users.profile_image, users.name, users.role, users.curso FROM posts
                              INNER JOIN users ON posts.user_id = users.id
                              WHERE posts.status $status_condition";
                if ($category_filter) {
                    $sql_query .= " AND posts.category = '" . $conn->real_escape_string($category_filter) . "'";
                }
                $sql_query .= " ORDER BY posts.created_at DESC LIMIT 20";

                $result = $conn->query($sql_query);

                if ($result->num_rows > 0) {
                    while ($post = $result->fetch_assoc()) {
                        $post_class = ($post['role'] == 'professor') ? 'post-item professor-post' : 'post-item';

                        echo "<div class='$post_class'>";
                        echo "<div class='post-content'>";
                        echo "<div class='post-user'>";
                        echo "<img src='" . htmlspecialchars($post['profile_image'] ?: 'uploads/default.jpg') . "' class='userimga' alt='Imagem do Usuário'>";
                        echo "<span style='color: " . getPostColor($post['curso']) . "; font-weight: bold;'>" . htmlspecialchars($post['name']) . "</span>";
                        $formatted_date = date("d/m/Y H:i", strtotime($post['created_at']));
                        echo "<span class='post-date'> - $formatted_date</span>";
                        echo "</div>";

                        $post_color = ($post['role'] == 'professor') ? '#000000' : getPostColor($post['curso']);
                        echo "<h3><a class='aaa' href='post.php?id=" . $post['id'] . "' style='color: $post_color;'>" . htmlspecialchars($post['title']) . "</a></h3>";

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
</body>
</html>
