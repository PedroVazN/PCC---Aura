document.querySelectorAll('.barrinha').forEach(barrinha => {
    barrinha.addEventListener('mouseenter', function () {
        // Atualiza imagem e descrição com os atributos data-img e data-desc
        const imgSrc = this.getAttribute('data-img');
        const desc = this.getAttribute('data-desc');

        const curiosidadeImg = document.getElementById('curiosidade-img');
        const curiosidadeDesc = document.getElementById('curiosidade-desc');

        curiosidadeImg.src = imgSrc;
        curiosidadeDesc.textContent = desc;

        // Exibe a seção de detalhes
        const detalhes = document.querySelector('.curiosidade-detalhes');
        detalhes.style.display = 'block';
    });
});
