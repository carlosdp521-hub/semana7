// animaciones.js - Script para animaciones de fondo
document.addEventListener('DOMContentLoaded', () => {
    const images = [
        'url(assets/bg1.jpg)',
        'url(assets/bg2.jpg)',
        'url(assets/bg3.jpg)',
        'url(assets/bg4.jpg)'
    ];
    let currentIndex = 0;
    const body = document.body;

    // Función para cambiar la imagen de fondo
    function changeBackgroundImage() {
        body.style.backgroundImage = images[currentIndex];
        body.style.backgroundSize = 'cover';
        body.style.backgroundPosition = 'center center';
        body.style.backgroundRepeat = 'no-repeat';
        currentIndex = (currentIndex + 1) % images.length;
    }

    // Cambia la imagen de fondo cada 8 segundos
    setInterval(changeBackgroundImage, 8000);

    // Muestra la primera imagen inmediatamente
    changeBackgroundImage();
});