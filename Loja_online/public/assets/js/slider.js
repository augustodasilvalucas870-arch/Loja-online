let slides = document.querySelectorAll('.slide');
let index = 0;

function mostrarSlide() {
    slides.forEach(slide => slide.classList.remove('active'));
    slides[index].classList.add('active');

    index = (index + 1) % slides.length;
}

/* Troca a cada 5 segundos */
setInterval(mostrarSlide, 5000);
