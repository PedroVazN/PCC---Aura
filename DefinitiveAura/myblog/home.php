<?php include('db.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal - Blog Aura</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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

    </header>

    <section class="banner">
        <img src="images/banner.png" alt="Banner Automobilística SENAI" class="banner-img">
    </section>

    <div class="main-container">
    <!-- Seção de Fórum -->
    <section class="forum">
        <div class="forum-options">
            <div class="option">
                <a href="index.php" class="lin">
                    <div class="card_forum">
                        <img src="images/batepapo.png" alt="Bate-papo" class="card-img">
                        <h4 class="card-title">Bate-papo</h4>
                        <p class="card-description">Participe de discussões ao vivo com outros usuários e tire suas dúvidas!</p>
                    </div>
                </a>
            </div>
            <div class="option">
                <a href="index.php" class="lin">
                    <div class="card_forum">
                        <img src="images/forum.png" alt="Perguntas e Respostas" class="card-img">
                        <h4 class="card-title">Perguntas e Respostas</h4>
                        <p class="card-description">Encontre respostas para suas perguntas ou ajude outros com suas dúvidas!</p>
                    </div>
                </a>
            </div>
        </div>
    </section>
</div>

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

        
    <!-- Seção de Cursos Gratuitos -->
    <section class="cursos-gratuitos">
    <h3>CURSOS GRATUITOS</h3>
    <div class="novidades-grid">
        <div class="card">
            <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/DAJPDEZNop9/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="background:#FFF; border:0; border-radius:8px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; padding:0;">
            </blockquote>
        </div>

        <div class="card">
            <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/DAGNeHANe74/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="background:#FFF; border:0; border-radius:8px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; padding:0;">
            </blockquote>
        </div>

        <div class="card">
            <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/p/C_0kVP2tJl2/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="background:#FFF; border:0; border-radius:8px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; padding:0;">
            </blockquote>
        </div>
    </div>
    <script async src="//www.instagram.com/embed.js"></script>
</section>




    <!-- Seção de Curiosidades -->
    <section class="curiosidades">
        <h3>CURIOSIDADES</h3>
        <img src="images/banner-carro.png" alt="Está pensando em comprar um carro zero?">
    </section>

    </div>

    <script src="js/carrosselInsta.js"></script>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
</body>

</html>