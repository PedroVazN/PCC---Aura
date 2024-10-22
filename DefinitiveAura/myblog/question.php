<?php 
include('db.php');
session_start(); // Certifique-se de iniciar a sessão

// Verificar se o ID da questão foi passado corretamente
if (isset($_GET['id'])) {
    $question_id = $_GET['id'];
} else {
    echo "<p>ID da questão não fornecido.</p>";
    exit;
}

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo "<p>Você precisa estar logado para responder a uma questão.</p>";
}

// Se o formulário foi submetido (envio de resposta)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_content'])) {
    $user_id = $_SESSION['user_id'];
    $reply_content = $_POST['reply_content'];

    // Insere a resposta no banco de dados
    $stmt = $conn->prepare("INSERT INTO answers (question_id, user_id, content) VALUES (?, ?, ?)");
    $stmt->bind_param('iis', $question_id, $user_id, $reply_content);
    if ($stmt->execute()) {
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
    <title>Visualizar Questão</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/question.css">
</head>

<header>
        <div class="header">
        <div class="user-info">
                <?php if (isset($user_data)): ?>
                    <div class="user-profile">
                        <?php
                        $profile_image = !empty($user_data['profile_image']) ? htmlspecialchars($user_data['profile_image']) : 'uploads/default.jpg';
                        echo "<img height='40px' src='$profile_image' alt='Imagem de Perfil' class='userimagem'>";
                        echo "<span class='username'>" . htmlspecialchars($user_data['name']) . "</span>";
                        ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="logo-container">
                <img src="images/logobranca.png" alt="Logo Aura">
            </div>
            <div class="nav">
            <nav>
                <a href="index.php">SAIR</a>
                <a href="create_post.php">PUBLICAR POST</a>
            </nav>
        </div>
        </div>
    
    </header>
<body>
    <div class="container">
        <div class="question-card">
            <?php
            // Consulta para obter a questão e os dados do usuário que a criou
            $query = "SELECT q.*, u.profile_image, u.name FROM questions q JOIN users u ON q.user_id = u.id WHERE q.id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $question_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verifica se a questão existe no banco de dados
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Exibe a imagem do usuário e o nome
                echo "<div class='user-info'>";
                echo "<img src='" . (!empty($row['profile_image']) ? htmlspecialchars($row['profile_image']) : 'images/default.jpg') . "' alt='Imagem do usuário' class='user-image'>";
                echo "<h3 class='name'>" . htmlspecialchars($row['name']) . "</h3>";
                echo "</div>";

                // Exibe o título e o conteúdo da questão
                echo "<h1 class='question-title'>" . htmlspecialchars($row['title']) . "</h1>";
                echo "<p class='question-content'>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
            } else {
                echo "<p>Questão não encontrada.</p>";
            }
            ?>
        </div>

        <!-- Formulário para enviar resposta -->
        <div class="reply-form">
            <?php if (isset($_SESSION['user_id'])): ?>
                <form action="question.php?id=<?php echo htmlspecialchars($question_id); ?>" method="POST">
                    <textarea name="reply_content" required placeholder="Digite sua resposta aqui..."></textarea>
                    <input type="hidden" name="question_id" value="<?php echo htmlspecialchars($question_id); ?>">
                    <button type="submit">Enviar Resposta</button>
                </form>
            <?php endif; ?>
        </div>

        <!-- Exibição das respostas -->
        <div class="answers-section">
            <?php
            // Consulta para obter as respostas da questão
            $query = "SELECT a.*, u.name, u.profile_image FROM answers a 
                      JOIN users u ON a.user_id = u.id 
                      WHERE a.question_id = ? ORDER BY a.created_at ASC";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('i', $question_id);
            $stmt->execute();
            $responses = $stmt->get_result();

            // Verifica se há respostas
            if ($responses->num_rows > 0) {
                echo "<h2>Respostas</h2>";
                while ($response = $responses->fetch_assoc()) {
                    echo "<div class='answer-item'>";

                    // Exibe a imagem de perfil do usuário que respondeu
                    $profile_image = !empty($response['profile_image']) ? htmlspecialchars($response['profile_image']) : 'images/default.jpg';
                    echo "<img src='$profile_image' alt='Imagem do usuário' class='user-image'>";

                    // Exibe o nome do usuário e a resposta
                    echo "<div class='answer-content'>";
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
</body>
</html>
