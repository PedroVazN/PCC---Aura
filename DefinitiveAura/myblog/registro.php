<?php
require_once __DIR__ . '/vendor/autoload.php';

use Twilio\Rest\Client;
use SendGrid\Mail\Mail;

// Carregar variáveis do .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

include('db.php');
session_start();

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $curso = $_POST['curso'];
    $phone = $_POST['phone'];
    $messageType = $_POST['message_type']; // Captura a escolha do usuário

    // Verifica se o e-mail ou número de telefone já está registrado
    $checkUser = "SELECT * FROM users WHERE email='$email' OR phone='$phone'";
    $result = $conn->query($checkUser);

    if ($result->num_rows == 0) {
        $verificationCode = rand(100000, 999999);

        // Upload da imagem de perfil (opcional)
        $profile_image = 'uploads/default.png';
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            $post_image = $_FILES['profile_image'];
            $pasta = "uploads/";
            $image_name = $post_image['name'];
            $new_image_name = uniqid();
            $extensao = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

            if (in_array($extensao, ["jpg", "png", "gif", "webp", "jfif", "jpeg"])) {
                $full_path = $pasta . $new_image_name . "." . $extensao;

                if (move_uploaded_file($post_image["tmp_name"], $full_path)) {
                    $profile_image = $full_path;
                } else {
                    echo "<p>Falha ao enviar arquivo</p>";
                }
            } else {
                echo "<p>Formato de arquivo não aceito</p>";
            }
        }

        // Inserir usuário no banco de dados com código de verificação
        $query = "INSERT INTO users (name, email, password, role, profile_image, curso, phone, verification_code) 
                  VALUES ('$name', '$email', '$password', '$role', '$profile_image', '$curso', '$phone', '$verificationCode')";

        if ($conn->query($query) === TRUE) {
            $sid = $_ENV['TWILIO_SID'];
            $token = $_ENV['TWILIO_TOKEN'];
            $twilioNumber = $_ENV['TWILIO_NUMBER'];
            $twilioNumberw = $_ENV['TWILIO_WHATSAPP_NUMBER'];
            $sendgridApiKey = $_ENV['SENDGRID_API_KEY'];

            try {
                $client = new Client($sid, $token);

                // Verifica o tipo de mensagem escolhido e envia para o canal adequado
                if ($messageType == 'sms') {
                    $client->messages->create(
                        $phone,
                        [
                            'from' => $twilioNumber,
                            'body' => "Olá $name, seu código de verificação é: $verificationCode."
                        ]
                    );
                    echo "<p>Código de verificação enviado para $phone via SMS.</p>";
                } elseif ($messageType == 'whatsapp') {
                    $client->messages->create(
                        'whatsapp:' . $phone,
                        [
                            'from' => 'whatsapp:' . $twilioNumberw,
                            'body' => "Olá $name, seu código de verificação é: $verificationCode."
                        ]
                    );
                    echo "<p>Código de verificação enviado para $phone via WhatsApp.</p>";
                } elseif ($messageType == 'email') {
                    // Enviar código por email usando o SendGrid
                    $sendgrid = new \SendGrid($sendgridApiKey);
                    $emailObj = new Mail();
                    $emailObj->setFrom("no-reply@definitiveaura.online", "DefinitiveAura");
                    $emailObj->setSubject("Código de Verificação");
                    $emailObj->addTo($email, $name);
                    $emailObj->addContent("text/plain", "Olá $name, seu código de verificação é: $verificationCode.");

                    try {
                        $response = $sendgrid->send($emailObj);
                        echo "<p>Código de verificação enviado para $email via e-mail.</p>";
                    } catch (Exception $e) {
                        echo "<p>Erro ao enviar e-mail: {$e->getMessage()}</p>";
                    }
                }

                $_SESSION['user_id'] = $conn->insert_id;
                header("Location: verify.php");
                exit();
            } catch (Exception $e) {
                echo "<p>Erro ao enviar mensagem: {$e->getMessage()}</p>";
            }
        } else {
            echo "<p>Erro ao registrar usuário. Tente novamente.</p>";
        }
    } else {
        echo "<p>E-mail ou telefone já registrado. Tente outro e-mail ou número de telefone.</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro com Bandeiras</title>
    <link rel="stylesheet" href="css1/registro.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
</head>

<body>
    <header class="header_registro">
        <div class="logos">
            <img src="images/logoazul.png" alt="Logo Aura" class="logo" width="150px">
        </div>
    </header>

    <div class="form-container">
        <div class="registro">
            <h1>Registrar-se</h1>
            <form action="registro.php" method="POST" enctype="multipart/form-data" id="registration-form">
                <p>
                    <label>Telefone</label>
                    <input id="phone" type="tel" name="phone" required>
                </p>
                <p>
                    <label>Nome</label>
                    <input type="text" name="name" placeholder="Nome completo" required>
                </p>
                <p>
                    <label>E-mail</label>
                    <input type="email" name="email" placeholder="@" required>
                </p>
                <p>
                    <label>Senha</label>
                    <input type="password" name="password" placeholder="Senha" required>
                </p>
                <p>
                    <label>Escolha como deseja receber o código de verificação:</label>
                    <select name="message_type" required>
                        <option value="sms">SMS</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="email">E-mail</option>
                    </select>
                </p>
                <p>
                    <label>Escolha seu cargo</label>
                    <select name="role" required>
                        <option value="aluno">Aluno</option>
                        <option value="professor">Professor</option>
                    </select>
                </p>
                <p>
                    <label>Curso</label>
                    <select name="curso" required>
                        <option value="ads">Análise e Desenvolvimento de Sistemas</option>
                        <option value="mecanica">Mecânica</option>
                        <option value="eletronica">Eletrônica</option>
                    </select>
                </p>
                <p>
                    <label>Imagem de Perfil</label>
                    <input type="file" name="profile_image" accept="image/*">
                </p>
                <button type="submit" name="register" class="botao">Registrar</button>
                <p>Já tem uma conta? <a href="login.php">Entrar</a></p>
            </form>
        </div>
    </div>

    <script src="js/paises.js"></script>
</body>

</html>