<?php include('db.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Post</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="container">
        <?php
        $post_id = $_GET['id'];
        $query = "SELECT * FROM posts WHERE id = $post_id";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<h1>" . $row['title'] . "</h1>";
            echo "<p>" . $row['content'] . "</p>";
        } else {
            echo "<p>Post não encontrado.</p>";
        }
        ?>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>
