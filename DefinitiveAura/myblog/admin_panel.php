<?php
include('db.php');
session_start();

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Aprovar post
if (isset($_GET['approve'])) {
    $post_id = $_GET['approve'];
    $query = "UPDATE posts SET status='approved' WHERE id='$post_id'";
    $conn->query($query);
    header("Location: admin_panel.php");
    exit();
}

// Excluir post
if (isset($_GET['delete'])) {
    $post_id = $_GET['delete'];
    $query = "DELETE FROM posts WHERE id='$post_id'";
    $conn->query($query);
    header("Location: admin_panel.php");
    exit();
}

// Buscar posts pendentes
$query = "SELECT * FROM posts WHERE status='pending'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link rel="stylesheet" href="css1/admin.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
</head>
<body>
<header class="header_admin">
    <div class="logos">
        <img src="images/logobranca.png" alt="Logo Aura" class="logo">
    </div>
</header>

<div class="admin-container">
    <h1>Painel de Administração</h1>
    <h2>Posts Pendentes</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Conteúdo</th>
                    <th>Categoria</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($post = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $post['id']; ?></td>
                        <td><?= htmlspecialchars($post['title']); ?></td>
                        <td><?= htmlspecialchars(substr($post['content'], 0, 100)); ?>...</td>
                        <td><?= htmlspecialchars($post['category']); ?></td>
                        <td>
                            <?php if (!empty($post['full_path'])): ?>
                                <a href="<?= $post['full_path']; ?>" target="_blank">Ver Imagem</a>
                            <?php else: ?>
                                Sem imagem
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="?approve=<?= $post['id']; ?>" class="btn-approve">Aprovar</a>
                            <a href="?delete=<?= $post['id']; ?>" class="btn-delete" onclick="return confirm('Tem certeza que deseja excluir este post?');">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Não há posts pendentes no momento.</p>
    <?php endif; ?>
</div>
</body>
</html>
