import './index.scss';
document.addEventListener('DOMContentLoaded', () => {
  const sliders = document.querySelectorAll('.js-testimonial-slider');

  sliders.forEach(slider => {
    const track = slider.querySelector('.testimonial-slider__track');
    const slides = slider.querySelectorAll('.testimonial-slider__slide');
    const prevBtn = slider.querySelector('.testimonial-slider__prev');
    const nextBtn = slider.querySelector('.testimonial-slider__next');

    let current = 0;

    const updateSlide = () => {
      const offset = -current * 100;
      track.style.transform = `translateX(${offset}%)`;
    };

    prevBtn.addEventListener('click', () => {
      current = (current - 1 + slides.length) % slides.length;
      updateSlide();
    });

    nextBtn.addEventListener('click', () => {
      current = (current + 1) % slides.length;
      updateSlide();
    });

    updateSlide();
  });
});
