<?php
include('db.php');

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    // Consulta para obter as respostas do post
    $query = "SELECT r.*, u.name, u.profile_image FROM responses r 
              JOIN users u ON r.user_id = u.id 
              WHERE r.post_id = ? ORDER BY r.created_at ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $post_id);
    $stmt->execute();
    $responses = $stmt->get_result();

    // Verifica se há respostas
    if ($responses->num_rows > 0) {
        echo "<h2>Respostas</h2>";
        while ($response = $responses->fetch_assoc()) {
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
}
?>
