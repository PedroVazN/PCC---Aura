<?php include('db.php'); ?>
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
            <img src="images/logo-senai.svg" alt="Logo SENAI">
            <img src="images/logo-ford.svg" alt="Logo Ford">
        </div>
    
    </header>

    <div class="container">
        <!-- Carrossel -->
        <div class="carousel-container">
            <h2 class="carousel-title">Nossos Espaços</h2>
            <div class="carousel">
                <img id="carouselImage" src="images/ca1.png" alt="Imagem 1">
            </div>
        </div>

        <!-- Lista de posts -->
        <aside class="posts-container">
            <h2 class="posts-title">Posts Recentes</h2>
            <div class="posts-list">
                <?php
                $query = "SELECT * FROM posts";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='post'>";
                        echo "<div>";
                        echo "<h2><a href='post.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['title']) . "</a></h2>";
                        echo "<p>" . substr(htmlspecialchars($row['content']), 0, 100) . "...</p>";
                        echo "</div>";
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
    <script src="js/carrosell.js"></script>
</body>

</html>
