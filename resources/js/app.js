import './bootstrap';

/* Scroll-reveal observer ------------------------------------------------- */
const observe = () => {
    const els = document.querySelectorAll('.reveal:not(.is-in)');
    if (!('IntersectionObserver' in window)) {
        els.forEach((el) => el.classList.add('is-in'));
        return;
    }
    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.classList.add('is-in');
                    io.unobserve(e.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -8% 0px' }
    );
    els.forEach((el) => io.observe(el));
};

document.addEventListener('DOMContentLoaded', observe);
document.addEventListener('livewire:navigated', observe);
document.addEventListener('livewire:initialized', observe);
