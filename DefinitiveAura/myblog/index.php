<?php
include('db.php');
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal - Blog Aura</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css1/home1.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
</head>

<body class="light-mode">
    <!-- Header -->
    <header class="header">
        <div class="logo-container">
            <img id="logoImg" src="images/logoazul.png" alt="Logo do site"> <!-- Ajuste o caminho da imagem -->
            <img src="images/logo-senai.svg" alt="Logo SENAI">
        </div>
        <div class="button-container">
            <a href="login.php">Login</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="configuracao.php" class="config-button">Configurações</a>
            <?php endif; ?>
            <!-- Botão de alternância de tema -->
            <button id="themeToggleBtn" onclick="toggleTheme()">
                <img src="images/moon-icon.png" id="themeIcon" alt="Modo Escuro">
            </button>
        </div>
    </header>
</body>

<!-- Banner -->
<section class="banner">
    <img src="images/banner.png" alt="Banner Automobilística SENAI" class="banner-img">
</section>

<div class="main-container">



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
                <a href="batepapo.php" class="lin">
                    <div class="card_forum">
                        <img src="images/forum.png" alt="Perguntas e Respostas" class="card-img">
                        <h4 class="card-title">Perguntas e Respostas</h4>
                        <p class="card-description">Encontre respostas para suas perguntas ou ajude outros com suas dúvidas!</p>
                    </div>
                </a>
            </div>
        </div>

    </section>

    <!-- Seção Comunidades -->
    <section class="comunidades">
        <h3>COMUNIDADES</h3>
        <div class="comunidade-options">
            <div class="option">
                <a href="ads.php" class="lin">
                    <div class="card_forum">
                        <img src="images/ads.png" alt="Comunidade ADS" class="card-img">
                        <h4 class="card-title">ADS</h4>
                        <p class="card-description">Explore conteúdos e discussões da área de Análise e Desenvolvimento de Sistemas!</p>
                    </div>
                </a>
            </div>
            <div class="option">
                <a href="mecanica.php" class="lin">
                    <div class="card_forum">
                        <img src="images/mecanica.png" alt="Comunidade Mecânica" class="card-img">
                        <h4 class="card-title">Mecânica</h4>
                        <p class="card-description">Participe da comunidade de Mecânica e compartilhe conhecimentos técnicos!</p>
                    </div>
                </a>
            </div>
            <div class="option">
                <a href="eletronica.php" class="lin">
                    <div class="card_forum">
                        <img src="images/eletronica.png" alt="Comunidade Eletrônica" class="card-img">
                        <h4 class="card-title">Eletrônica</h4>
                        <p class="card-description">Envolva-se com a comunidade de Eletrônica e expanda suas habilidades!</p>
                    </div>
                </a>
            </div>
        </div>
    </section>


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



    <section class="curiosidades">
    <h2>Curiosidades</h2>
    <div class="curiosidade-container">
        <div class="barrinha" data-img="images/curisiodade1.jpg" data-desc="O SENAI qualifica milhões de trabalhadores e é o maior complexo de educação profissional da América Latina."></div>
        <div class="barrinha" data-img="images/curisiodade2.png" data-desc="Os cursos do SENAI atendem às necessidades do mercado, atualizando estudantes em tecnologia e processos."></div>
        <div class="barrinha" data-img="images/curisiodade3.png" data-desc="O SENAI oferece mais de 300 opções de cursos EAD, com simuladores e vídeos interativos."></div>
        <div class="barrinha" data-img="images/curisiodade4.jpg" data-desc="O SENAI possui professores capacitados, alinhados às demandas do mercado de trabalho."></div>
        <div class="barrinha" data-img="images/curisiodade5.png" data-desc="Com unidades em 2.700 municípios, o SENAI está presente em todo o Brasil."></div>
        <div class="barrinha" data-img="images/curisiodade6.png" data-desc="O SENAI promove inovação e tecnologia, fortalecendo a indústria brasileira."></div>
        <div class="barrinha" data-img="images/curisiodade7.png" data-desc="Cursos para todas as fases da vida: qualificação, técnico, graduação, mestrado e doutorado."></div>
    </div>
    <div class="curiosidade-detalhes">
        <img id="curiosidade-img" src="" alt="Imagem da Curiosidade">
        <p id="curiosidade-desc"></p>
    </div>
</section>




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

<!-- Seção de Mapa -->
<section class="mapa">
    <h2>Localização</h2>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3656.389694877207!2d-46.6117951!3d-23.5900785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce5a9bb45f3615%3A0x7e1495f23b1e1f07!2sR.%20Moreira%20de%20God%C3%B3i%2C%20226%20-%20Ipiranga%2C%20S%C3%A3o%20Paulo%20-%20SP%2C%2004227-000!5e0!3m2!1spt-BR!2sbr!4v1698333440406!5m2!1spt-BR!2sbr" allowfullscreen="" loading="lazy"></iframe>
</section>

<script src="js/carrosselInsta.js"></script>

<!-- Footer -->
<?php include('includes/footer.php'); ?>

</body>

<script>
function toggleTheme() {
    const body = document.body;
    const themeIcon = document.getElementById('themeIcon');
    const chatIcon = document.querySelector('.forum-options .option:nth-child(1) .card-img');
    const questionIcon = document.querySelector('.forum-options .option:nth-child(2) .card-img');
    const logoImg = document.getElementById("logoImg");
    
    // Selecionar as imagens das comunidades
    const comunidadeIcons = document.querySelectorAll('.comunidade-options .card_forum .card-img');

    body.classList.toggle('dark-mode');

    if (body.classList.contains('dark-mode')) {
        logoImg.src = 'images/logobranca.png';
        themeIcon.src = 'images/sun-icon.png';
        chatIcon.src = 'images/bate-papo-dark.png'; // Caminho para a imagem branca do botão de bate-papo
        questionIcon.src = 'images/perguntas-dark.png'; // Caminho para a imagem branca do botão de perguntas

        // Alterar as imagens das comunidades para modo escuro
        comunidadeIcons.forEach((icon, index) => {
            const darkIcons = [
                'images/adsw.png',
                'images/mecanicaw.png',
                'images/eletronicaw.png',
            ];
            icon.src = darkIcons[index];
        });

    } else {
        logoImg.src = 'images/logoazul.png';
        themeIcon.src = 'images/moon-icon.png';
        chatIcon.src = 'images/batepapo.png'; // Caminho original para a imagem do botão de bate-papo
        questionIcon.src = 'images/forum.png'; // Caminho original para a imagem do botão de perguntas

        // Alterar as imagens das comunidades para modo claro
        comunidadeIcons.forEach((icon, index) => {
            const lightIcons = [
                'images/ads.png',
                'images/mecanica.png',
                'images/eletronica.png',
            ];
            icon.src = lightIcons[index];
        });
    }
}

</script>

<script src="js/carosselcu.js"></script>

</html>