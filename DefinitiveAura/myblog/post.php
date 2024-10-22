<?php
include('db.php');
session_start();

// Verificar se o ID do post foi passado corretamente
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
} else {
    echo "<p>ID do post não fornecido.</p>";
    exit;
}

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo "<p>Você precisa estar logado para responder a um post.</p>";
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Função para obter a contagem de curtidas
function get_like_count($post_id, $conn) {
    $sql = "SELECT COUNT(*) AS like_count FROM likes WHERE post_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    return $data['like_count'];
}

// Função para verificar se o usuário curtiu o post
function user_liked($post_id, $user_id, $conn) {
    $sql = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Post</title>
    <link rel="stylesheet" href="css/post.css">
    <link rel="stylesheet" href="css/header.css">
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include('includes/header.php'); ?>

    <div class="container">
        <div class="post-card">
            <?php
            // Consulta para obter o post e os dados do usuário que o criou
            $query = "SELECT p.*, u.profile_image, u.name FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $post_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verifica se o post existe no banco de dados
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

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
                echo "<div class='like-section'>";
                echo "<button class='like-btn' data-post-id='$post_id'>";
                echo user_liked($post_id, $user_id, $conn) ? 'Descurtir' : 'Curtir';
                echo "</button>";
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
                <form id="reply-form">
                    <textarea id="reply-content" required placeholder="Digite sua resposta aqui..."></textarea>
                    <input type="hidden" id="post-id" value="<?php echo htmlspecialchars($post_id); ?>">
                    <button type="submit">Enviar Resposta</button>
                </form>
            <?php endif; ?>
        </div>

        <!-- Exibição das respostas -->
        <div class="responses-section">
            <!-- As respostas serão carregadas aqui via AJAX -->
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

<!-- JavaScript para enviar respostas via AJAX e atualizar em tempo real -->
<script>
    document.getElementById('reply-form').addEventListener('submit', function(e) {
        e.preventDefault();  // Previne o envio normal do formulário

        const postId = document.getElementById('post-id').value;
        const replyContent = document.getElementById('reply-content').value;

        if (replyContent.trim() === "") {
            alert('Por favor, insira um conteúdo válido antes de enviar.');
            return;
        }

        // Exibe uma mensagem de carregamento (opcional)
        const submitButton = document.querySelector('#reply-form button[type="submit"]');
        submitButton.innerHTML = 'Enviando...';

        fetch('send_reply.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `post_id=${postId}&reply_content=${encodeURIComponent(replyContent)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('reply-content').value = ''; // Limpa o campo de texto
                submitButton.innerHTML = 'Enviar Resposta';  // Restaura o botão
                loadResponses();  // Atualiza as respostas em tempo real
            } else {
                alert('Erro ao enviar resposta. Por favor, tente novamente.');
                submitButton.innerHTML = 'Enviar Resposta';  // Restaura o botão
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
            alert('Houve um problema ao tentar enviar a resposta.');
            submitButton.innerHTML = 'Enviar Resposta';  // Restaura o botão
        });
    });

    // Função para carregar as respostas em tempo real
    function loadResponses() {
        const postId = document.getElementById('post-id').value;

        fetch(`get_responses.php?post_id=${postId}`)
            .then(response => response.text())
            .then(data => {
                document.querySelector('.responses-section').innerHTML = data;
            })
            .catch(error => {
                console.error('Erro ao carregar respostas:', error);
            });
    }

    // Atualiza as respostas a cada 10 segundos
    setInterval(loadResponses, 10000);

    // Carrega as respostas quando a página for carregada
    window.onload = loadResponses;
</script>

</body>

</html>
