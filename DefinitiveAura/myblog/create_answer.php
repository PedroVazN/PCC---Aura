<?php
include('db.php');
session_start();

// Verificar se o ID da questão foi passado corretamente
if (isset($_GET['question_id'])) {
    $question_id = $_GET['question_id'];
} else {
    echo "<p>ID da pergunta não fornecido.</p>";
    exit;
}

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo "<p>Você precisa estar logado para responder a uma questão.</p>";
    exit;
}

// Se o formulário foi submetido (envio de resposta)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_content'])) {
    $user_id = $_SESSION['user_id'];
    $reply_content = $_POST['reply_content'];

    // Inserir a resposta na tabela "answers"
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
    <title>Criar Resposta</title>
    <link rel="stylesheet" href="css1/createPost.css">
</head>
<body>
    <header>
        <div class="logos">
            <img src="images/logobranca.png" alt="Logo Aura" class="logo">
        </div>
    </header>

    <div class="form-container">
        <form action="create_answer.php" method="POST" enctype="multipart/form-data">
            <label for="title">Título</label>
            <input type="text" id="title" name="title" placeholder="Digite o título da sua Resposta" required>

            <label for="content">Conteúdo</label>
            <textarea id="content" name="content" rows="5" placeholder="Escreva o conteúdo da Resposta" required></textarea>

            <button type="submit" name="create_answer" class="botao">Criar Resposta</button>
        </form>
    </div>
</body>
</html>
