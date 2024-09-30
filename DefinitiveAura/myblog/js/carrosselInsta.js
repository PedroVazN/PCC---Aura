const carouselInner = document.getElementById('carouselInner');
            const nextButton = document.getElementById('nextButton');
            const prevButton = document.getElementById('prevButton');

            let currentIndex = 0;
            const items = carouselInner.children;
            const totalItems = items.length;

            function updateCarousel() {
                const offset = -currentIndex * 100; // Calcula o deslocamento baseado no índice atual
                carouselInner.style.transform = `translateX(${offset}%)`;
            }

            nextButton.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % totalItems; // Move para o próximo item
                updateCarousel();
            });

            prevButton.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + totalItems) % totalItems; // Move para o item anterior
                updateCarousel();
            });

            // Mudar automaticamente a imagem a cada 5 segundos
            setInterval(() => {
                currentIndex = (currentIndex + 1) % totalItems; // Move para o próximo item
                updateCarousel();
            }, 5000);