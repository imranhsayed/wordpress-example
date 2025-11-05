import './index.scss';

document.addEventListener('DOMContentLoaded', () => {
    // Select all carousel elements on the page
    const carousels = document.querySelectorAll('.carousel-component');

    carousels.forEach((carousel) => {
        const slides = carousel.querySelectorAll('.carousel-component__slide');
        const nextBtn = carousel.querySelector('.carousel-component__next');
        const prevBtn = carousel.querySelector('.carousel-component__prev');
        const dots = carousel.querySelectorAll('.carousel-component__dot');

        let currentIndex = 0;

        const updateSlides = () => {
            slides.forEach((slide, idx) => {
                slide.classList.toggle('is-active', idx === currentIndex);
            });

            dots?.forEach((dot, idx) => {
                dot.classList.toggle('is-active', idx === currentIndex);
            });
        };

        nextBtn?.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % slides.length;
            updateSlides();
        });

        prevBtn?.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            updateSlides();
        });

        dots?.forEach((dot, idx) => {
            dot.addEventListener('click', () => {
                currentIndex = idx;
                updateSlides();
            });
        });

        // Initialize the carousel
        updateSlides();
    });
});
