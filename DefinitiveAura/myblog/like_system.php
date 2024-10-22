<?php
include('db.php');
session_start();

if (isset($_POST['post_id']) && isset($_SESSION['user_id'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];

    // Verifica se o usuário já curtiu o post
    $check_like_sql = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
    $stmt = $conn->prepare($check_like_sql);
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Se já curtiu, remove o like
        $delete_like_sql = "DELETE FROM likes WHERE post_id = ? AND user_id = ?";
        $stmt = $conn->prepare($delete_like_sql);
        $stmt->bind_param("ii", $post_id, $user_id);
        $stmt->execute();
        $response = array('status' => 'removed');
    } else {
        // Se ainda não curtiu, adiciona o like
        $add_like_sql = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
        $stmt = $conn->prepare($add_like_sql);
        $stmt->bind_param("ii", $post_id, $user_id);
        $stmt->execute();
        $response = array('status' => 'liked');
    }

    // Conta o número total de likes no post
    $count_likes_sql = "SELECT COUNT(*) AS like_count FROM likes WHERE post_id = ?";
    $stmt = $conn->prepare($count_likes_sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $like_data = $result->fetch_assoc();

    $response['like_count'] = $like_data['like_count'];

    echo json_encode($response);
    exit;
}
?>
