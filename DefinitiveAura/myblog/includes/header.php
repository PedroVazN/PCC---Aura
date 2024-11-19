<?php
include('db.php');
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Consulta os dados do usuário
    $sql = "SELECT profile_image, name FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();
}

// Filtro de categoria
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
    </main>

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
