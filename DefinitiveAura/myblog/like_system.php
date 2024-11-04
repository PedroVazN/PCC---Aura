<?php
include('db.php');
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não está logado.']);
    exit;
<<<<<<< HEAD
=======
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    // Verificar se o usuário já curtiu o post
    $sql = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Se já curtiu, então remove a curtida (descurtir)
        $sql = "DELETE FROM likes WHERE post_id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $post_id, $user_id);
        $stmt->execute();
        $status = 'unliked';
    } else {
        // Se não curtiu, então adiciona a curtida
        $sql = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $post_id, $user_id);
        $stmt->execute();
        $status = 'liked';
    }

    // Obter a nova contagem de curtidas
    $sql = "SELECT COUNT(*) AS like_count FROM likes WHERE post_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $like_data = $result->fetch_assoc();

    echo json_encode(['status' => $status, 'like_count' => $like_data['like_count']]);
>>>>>>> 9a48be218305e63711b9c157232963c994d332cc
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    // Verificar se o usuário já curtiu o post
    $sql = "SELECT * FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Se já curtiu, então remove a curtida (descurtir)
        $sql = "DELETE FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";
        $conn->query($sql);
        $status = 'unliked';
    } else {
        // Se não curtiu, então adiciona a curtida
        $sql = "INSERT INTO likes (post_id, user_id) VALUES ('$post_id', '$user_id')";
        $conn->query($sql);
        $status = 'liked';
    }

    // Obter a nova contagem de curtidas
    $sql = "SELECT COUNT(*) AS like_count FROM likes WHERE post_id = '$post_id'";
    $result = $conn->query($sql);
    $like_data = $result->fetch_assoc();

    echo json_encode(['status' => $status, 'like_count' => $like_data['like_count']]);
}
?>
