let images = ["images/ca1.png", "images/ca2.jpg", "images/ca3.jpg", "images/ca4.jpg", "images/ca5.jpg", "images/ca6.jpg", "images/ca7.jpg"];
let currentIndex = 0;

function changeImage() {
    const carouselImage = document.getElementById('carouselImage');
    currentIndex = (currentIndex + 1) % images.length;
    carouselImage.src = images[currentIndex];
}

setInterval(changeImage, 2500); 