<?php
include('db.php');
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Aura</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <div class="logo-container">
            <img src="images/logo-aura.svg" alt="Logo Aura">
        </div>
    </header>

    <div class="container">
        <!-- Lista de posts -->
        <aside class="posts-container">
            <h2 class="posts-title">Posts Recentes</h2>
            <div class="posts-list">
                <?php
                // Exibir apenas posts aprovados
                $query = "SELECT * FROM posts WHERE status='pending' ORDER BY created_at DESC";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='post'>";
                        
                        // Exibir imagem do post se houver
                        if (!empty($row['nome'])) {
                            echo "<img src='uploads/" . htmlspecialchars($row['nome']) . "' alt='Imagem do post' class='post-image'>";
                        }

                        // Exibir título e conteúdo do post
                        echo "<h2><a href='post.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['title']) . "</a></h2>";
                        echo "<p>" . substr(htmlspecialchars($row['content']), 0, 100) . "...</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Sem posts disponíveis.</p>";
                }
                ?>
            </div>
        </aside>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>
