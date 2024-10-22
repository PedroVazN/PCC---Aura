<?php
include('db.php');
session_start();

header('Content-Type: application/json');  // Define o tipo de retorno como JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_content'], $_POST['post_id']) && isset($_SESSION['user_id'])) {
    $reply_content = $_POST['reply_content'];
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];

    if (empty($reply_content)) {
        echo json_encode(['success' => false, 'message' => 'O conteúdo da resposta está vazio.']);
        exit;
    }

    // Insere a resposta no banco de dados
    $stmt = $conn->prepare("INSERT INTO responses (post_id, user_id, content) VALUES (?, ?, ?)");
    $stmt->bind_param('iis', $post_id, $user_id, $reply_content);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Falha ao inserir resposta no banco de dados.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida ou usuário não autenticado.']);
}
?>
