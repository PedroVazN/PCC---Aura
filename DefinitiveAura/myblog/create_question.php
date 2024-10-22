<?php
include('db.php');
session_start();

// Verifica se o formulário foi enviado
if (isset($_POST['create_question'])) {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

        // Insere o post no banco de dados com status 'pending'
        $query = "INSERT INTO questions (user_id, title, content) 
                  VALUES ('$user_id', '$title', '$content')";

        if ($conn->query($query) === TRUE) {
            echo "<p>Pergunta criada com sucesso! Aguarde a aprovação do administrador.</p>";
        } else {
            echo "<p>Erro ao criar a pergunta: " . $conn->error . "</p>";
        }

    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Post</title>
    <link rel="stylesheet" href="css/createPost.css">
</head>
<body>
    <header>
        <div class="logos">
            <img src="images/logobranca.png" alt="Logo Aura" class="logo">
        </div>
    </header>

    <div class="form-container">
        <form action="create_question.php" method="POST" enctype="multipart/form-data">
            <label for="title">Título</label>
            <input type="text" id="title" name="title" placeholder="Digite o título da sua Pergunta" required>

            <label for="content">Conteúdo</label>
            <textarea id="content" name="content" rows="5" placeholder="Escreva o conteúdo da Pergunta" required></textarea>

            <button type="submit" name="create_question" class="botao">Criar Pergunta</button>
        </form>
    </div>
</body>
</html>
