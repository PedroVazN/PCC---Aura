<?php
include('db.php');
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT profile_image, name FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fórum de Perguntas e Respostas</title>
    <link rel="stylesheet" href="css1/footer.css">
    <link rel="stylesheet" href="css1/batepapo.css">
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
            <a href="create_question.php">PERGUNTAR</a>
        </nav>
    </header>
    <br>
    <h1 class="h1Des">Perguntas Recentes</h1>
    <br>
    <div class="container">
        <!-- Seção principal para exibir perguntas e respostas -->
        <section class="qa-section">
            <div class="main-question">
                <?php
                // Exibe a pergunta mais recente
                $sql_main = "SELECT questions.*, users.name, users.profile_image FROM questions
                             INNER JOIN users ON questions.user_id = users.id
                             ORDER BY questions.created_at DESC LIMIT 1";
                $result_main = $conn->query($sql_main);

                if ($result_main->num_rows > 0) {
                    $main_question = $result_main->fetch_assoc();
                    echo "<div class='card'>"; // Card container
                    echo "<h2>" . htmlspecialchars($main_question['title']) . "</h2>";
                    echo "<h4>Perguntado por: " . htmlspecialchars($main_question['name']) . "</h4>";
                    echo "<br><p>" . htmlspecialchars($main_question['content']) . "</p>";

                    // Exibe as respostas associadas à pergunta
                    $sql_answers = "SELECT answers.*, users.name FROM answers
                                    INNER JOIN users ON answers.user_id = users.id
                                    WHERE answers.question_id = ?";
                    $stmt_answers = $conn->prepare($sql_answers);
                    $stmt_answers->bind_param("i", $main_question['id']);
                    $stmt_answers->execute();
                    $result_answers = $stmt_answers->get_result();

                    if ($result_answers->num_rows > 0) {
                        echo "<h3>Respostas:</h3>";
                        while ($answer = $result_answers->fetch_assoc()) {
                            echo "<div class='answer-item'>";
                            echo "<p><strong>" . htmlspecialchars($answer['name']) . "</strong>: " . htmlspecialchars($answer['content']) . "</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<br><h5>Sem respostas ainda.</h5>";
                    }

                    // Botão para criar uma resposta
                    if (isset($_SESSION['user_id'])) {
                        echo "<br><a href='create_answer.php?question_id=" . $main_question['id'] . "' class='button'>Responder</a>";
                    } else {
                        echo "<p><a href='login.php'>Faça login para responder</a></p>";
                    }

                    echo "</div>"; // Fecha o card
                }
                ?>
            </div>

            <h1 class="outherh1">Outras Perguntas</h1>

            <div class="other-questions">
                <?php
                // Exibe as outras perguntas recentes
                $sql_query = "SELECT questions.*, users.name FROM questions
                              INNER JOIN users ON questions.user_id = users.id
                              ORDER BY questions.created_at DESC LIMIT 1, 20";
                $result_query = $conn->query($sql_query);

                if ($result_query->num_rows > 0) {
                    while ($question = $result_query->fetch_assoc()) {
                        echo "<div class='card'>"; // Card container
                        echo "<h3><a href='question.php?id=" . $question['id'] . "'>" . htmlspecialchars($question['title']) . "</a></h3>";
                        echo "<h4>Perguntado por: " . htmlspecialchars($question['name']) . "</h4>";
                        echo "</div>"; // Fecha o card
                    }
                } else {
                    echo "<p>Sem perguntas disponíveis.</p>";
                }
                ?>
            </div>
        </section>
    </div>



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

    <?php include('includes/footer.php'); ?>
</body>

</html>