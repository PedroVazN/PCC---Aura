<?php
include('db.php');
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Comunidade ADS</title>
    <link rel="stylesheet" href="css1/style.css">
</head>
<body>
    <header>
        <h1>Comunidade ADS</h1>
    </header>
    <main>
        <section class="posts-section">
            <?php
            // Exibe os posts da categoria 'ADS'
            $sql_query = "SELECT posts.*, users.name FROM posts 
                          INNER JOIN users ON posts.user_id = users.id 
                          WHERE users.course = 'ADS' ORDER BY posts.created_at DESC";
            $result = $conn->query($sql_query);

            if ($result->num_rows > 0) {
                while ($post = $result->fetch_assoc()) {
                    echo "<div class='post-item'>";
                    echo "<h3>" . htmlspecialchars($post['title']) . "</h3>";
                    echo "<p>" . htmlspecialchars($post['content']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>Sem posts na comunidade ADS.</p>";
            }
            ?>
        </section>
    </main>
</body>
</html>
