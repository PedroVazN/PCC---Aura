<?php include('db.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal - Blog Aura</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/header.css">
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="logo-container">
            <img src="images/logoazul.png" alt="Logo Aura">
            <img src="images/logo-senai.svg" alt="Logo SENAI">
        </div>
        <a href="login.php">login</a>
    </header>

    <!-- Banner -->
    <section class="banner">
        <img src="images/banner.png" alt="Banner Automobilística SENAI" class="banner-img">
    </section>

    <div class="main-container">
        
        <section class="novidades">
            <h1>NOVIDADES</h1>
            <div class="novidades-grid">
                <div class="card">
                    <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/DAT5OY_t-9Z/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14"></blockquote>
                </div>
                <div class="card">
                    <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/DAZA0WrurEA/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14"></blockquote>
                </div>
                <div class="card">
                    <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/DAbG1s8N2hD/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14"></blockquote>
                </div>
            </div>
        </section>

        <!-- Seção de Fórum -->
        <section class="forum">
            <h3>FÓRUM DE DISCUSSÕES</h3>
            <div class="forum-options">
                <div class="option">
                    <a href="forum.php" class="lin">
                        <div class="card_forum">
                            <img src="images/batepapo.png" alt="Bate-papo" class="card-img">
                            <h4 class="card-title">Bate-papo</h4>
                            <p class="card-description">Participe de discussões ao vivo com outros usuários e tire suas dúvidas!</p>
                        </div>
                    </a>
                </div>
                <div class="option">
                    <a href="chat.php" class="lin">
                        <div class="card_forum">
                            <img src="images/forum.png" alt="Perguntas e Respostas" class="card-img">
                            <h4 class="card-title">Perguntas e Respostas</h4>
                            <p class="card-description">Encontre respostas para suas perguntas ou ajude outros com suas dúvidas!</p>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- Seção de Novidades -->

        <!-- Seção de Cursos Gratuitos -->
        <section class="cursos-gratuitos">
            <h3>CURSOS GRATUITOS</h3>
            <div class="novidades-grid">
                <div class="card">
                    <a href="https://www.instagram.com/p/DAJPDEZNop9/?utm_source=ig_embed&ig_rid=f3a30ac6-885f-49a0-8931-5fdde3e7f4d1">
                        <img src="images/curso1.png" alt="curso1"></img>
                    </a>
                </div>
                <div class="card">
                    <a href="https://www.instagram.com/p/DAGNeHANe74/?utm_source=ig_embed&ig_rid=fdcaf083-49ea-458d-bb7e-e0948d7d2ebc">
                        <img src="images/curso2.png" alt="curso1"></img>
                    </a>
                </div>
                <div class="card">
                    <a href="https://www.instagram.com/p/C_0kVP2tJl2/?utm_source=ig_embed&ig_rid=a0b57d37-103b-48e2-8a49-7730429ed79f">
                        <img src="images/curso3.png" alt="curso1"></img>
                    </a>
                </div>
            </div>
            <script async src="//www.instagram.com/embed.js"></script>
        </section>
    </div>

    <script src="js/carrosselInsta.js"></script>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
</body>

</html>