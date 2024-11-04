<?php
include('db.php');
session_start();

// Verificar se o ID do post foi passado corretamente
if (isset($_GET['id'])) {
    $post_id = mysqli_real_escape_string($conn, $_GET['id']);
} else {
    echo "<p>ID do post não fornecido.</p>";
    exit;
}

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo "<p>Você precisa estar logado para responder a um post.</p>";
}

$user_id = isset($_SESSION['user_id']) ? mysqli_real_escape_string($conn, $_SESSION['user_id']) : null;

// Função para obter a contagem de curtidas
function get_like_count($post_id, $conn)
{
    $sql = "SELECT COUNT(*) AS like_count FROM likes WHERE post_id = '$post_id'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);
    return $data['like_count'];
}

// Função para verificar se o usuário curtiu o post
function user_liked($post_id, $user_id, $conn)
{
    $sql = "SELECT * FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result) > 0;
}

// Se o formulário foi submetido (envio de resposta)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_content'])) {
    $reply_content = mysqli_real_escape_string($conn, $_POST['reply_content']);
    $sql = "INSERT INTO responses (post_id, user_id, content) VALUES ('$post_id', '$user_id', '$reply_content')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<p>Resposta enviada com sucesso!</p>";
    } else {
        echo "<p>Erro ao enviar resposta. Tente novamente.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Post</title>
    <link rel="stylesheet" href="css1/post.css">
<<<<<<< HEAD
    <link rel="icon" type="image/png" href="images/favicon.png">
=======
>>>>>>> 9a48be218305e63711b9c157232963c994d332cc
    <link rel="stylesheet" href="css1/header.css">
    <link rel="stylesheet" href="css1/footer.css">
    <style>
        .like-btn {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>
<header>
        <div class="logos">
            <img src="images/logobranca.png" alt="Logo Aura" class="logo">
        </div>
    </header>
  

    <div class="container">
        <div class="post-card">
            <?php
            // Consulta para obter o post e os dados do usuário que o criou
            $query = "SELECT p.*, u.profile_image, u.name FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = '$post_id'";
            $result = mysqli_query($conn, $query);

            // Verifica se o post existe no banco de dados
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                // Exibe a imagem do usuário e o nome
                echo "<div class='user-info'>";
                echo "<img src='" . (!empty($row['profile_image']) ? htmlspecialchars($row['profile_image']) : 'images/default.jpg') . "' alt='Imagem do usuário' class='user-image'>";
                echo "<h3 class='name'>" . htmlspecialchars($row['name']) . "</h3>";
                echo "</div>";

                // Exibe o título e o conteúdo do post
                echo "<h1 class='post-title'>" . htmlspecialchars($row['title']) . "</h1>";
                echo "<p class='post-content'>" . nl2br(htmlspecialchars($row['content'])) . "</p>";

                // Exibe a imagem do post, se houver
                if (!empty($row['full_path'])) {
                    $image_path = htmlspecialchars($row['full_path']);
                    echo "<img src='$image_path' class='imgposte' alt='Imagem do Post'>";
                }

                // Exibe o botão de curtir e a contagem de likes
                $liked = user_liked($post_id, $user_id, $conn);
                echo "<div class='like-section'>";
                echo "<img src='images/" . ($liked ? 'coracaocheio.png' : 'coracaovazio.png') . "' class='like-btn' data-post-id='$post_id' alt='Curtir'>";
                echo "<span class='like-count'>" . get_like_count($post_id, $conn) . "</span> Likes";
                echo "</div>";
            } else {
                echo "<p>Post não encontrado.</p>";
            }
            ?>
        </div>

        <!-- Formulário para enviar resposta -->
        <div class="reply-form">
            <?php if (isset($_SESSION['user_id'])): ?>
                <form action="post.php?id=<?php echo htmlspecialchars($post_id); ?>" method="POST">
                    <textarea name="reply_content" required placeholder="Digite sua resposta aqui..."></textarea>
                    <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post_id); ?>">
                    <button type="submit">Enviar Resposta</button>
                </form>
            <?php endif; ?>
        </div>

        <!-- Exibição das respostas -->
        <div class="responses-section">
            <?php
            // Consulta para obter as respostas do post
            $query = "SELECT r.*, u.name, u.profile_image FROM responses r 
                      JOIN users u ON r.user_id = u.id 
                      WHERE r.post_id = '$post_id' ORDER BY r.created_at ASC";
            $responses = mysqli_query($conn, $query);

            // Verifica se há respostas
            if (mysqli_num_rows($responses) > 0) {
                echo "<h2>Respostas</h2>";
                while ($response = mysqli_fetch_assoc($responses)) {
                    echo "<div class='response-item'>";

                    // Exibe a imagem de perfil do usuário que respondeu
                    $profile_image = !empty($response['profile_image']) ? htmlspecialchars($response['profile_image']) : 'images/default.jpg';
                    echo "<img src='$profile_image' alt='Imagem do usuário' class='user-image'>";

                    // Exibe o nome do usuário e a resposta
                    echo "<div class='response-content'>";
                    echo "<h4>" . htmlspecialchars($response['name']) . "</h4>";
                    echo "<p>" . nl2br(htmlspecialchars($response['content'])) . "</p>";
                    echo "<small>Respondido em: " . date('d/m/Y H:i', strtotime($response['created_at'])) . "</small>";
                    echo "</div>";

                    echo "</div>";
                }
            } else {
                echo "<p>Sem respostas ainda. Seja o primeiro a responder!</p>";
            }
            ?>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <!-- JavaScript para gerenciamento de curtidas -->
    <script>
        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', function() {
                const postId = this.getAttribute('data-post-id');
                const likeCountElem = this.nextElementSibling;

                fetch('like_system.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `post_id=${postId}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'liked') {
                            this.src = 'images/coracaocheio.png'; // Verifique se o nome do arquivo está correto
                        } else {
                            this.src = 'images/coracaovazio.png'; // Verifique se o nome do arquivo está correto
                        }
                        likeCountElem.innerHTML = data.like_count + ' Likes';
                    });
            });
        });
    </script>
</body>

</html>
