<?php
include('db.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Post</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="container">
        <div class="post-card">
            <?php
            // Verificar se o ID do post foi passado corretamente
            if (isset($_GET['id'])) {
                $post_id = $_GET['id'];
                $query = "SELECT p.*, u.profile_image FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('i', $post_id);
                $stmt->execute();
                $result = $stmt->get_result();

                // Verifica se o post existe no banco de dados
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    // Exibe a imagem do usuário
                    echo "<div class='user-info'>";
                    echo "<img src='" . (!empty($row['profile_image']) ? htmlspecialchars($row['profile_image']) : 'images/default.jpg') . "' alt='Imagem do usuário' class='user-image'>";
                    echo "</div>";

                    // Exibe o título e o conteúdo do post
                    echo "<h1 class='post-title'>" . htmlspecialchars($row['title']) . "</h1>";
                    echo "<p class='post-content'>" . nl2br(htmlspecialchars($row['content'])) . "</p>";

                    // Exibe a imagem do post
                    if (!empty($row['image'])) {
                        echo "<img src='" . htmlspecialchars($row['image']) . "' alt='Imagem do post' class='post-image'>";
                    }
                } else {
                    echo "<p>Post não encontrado.</p>";
                }
            } else {
                echo "<p>ID do post não fornecido.</p>";
            }
            ?>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>
