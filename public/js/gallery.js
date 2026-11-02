'use strict';

document.querySelectorAll('[data-project-group]').forEach(group => {
    const track = group.querySelector('[data-gallery-track]');
    const controls = group.querySelector('[data-gallery-controls]');
    const previous = group.querySelector('[data-gallery-direction="-1"]');
    const next = group.querySelector('[data-gallery-direction="1"]');
    const scrollHint = group.querySelector('[data-gallery-scroll-hint]');
    const staticHint = group.querySelector('[data-gallery-static-hint]');
    if (!track || !controls || !previous || !next) return;

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    function updateControls() {
        const maximum = track.scrollWidth - track.clientWidth;
        const overflow = maximum > 2;
        controls.hidden = !overflow;
        previous.disabled = !overflow || track.scrollLeft <= 2;
        next.disabled = !overflow || track.scrollLeft >= maximum - 2;
        if (scrollHint) scrollHint.hidden = !overflow;
        if (staticHint) staticHint.hidden = overflow;
    }

    function move(direction) {
        const card = track.querySelector('.project-card');
        if (!card) return;
        const step = card.getBoundingClientRect().width + parseFloat(getComputedStyle(track).columnGap || 0);
        track.scrollBy({ left: direction * step, behavior: reducedMotion.matches ? 'instant' : 'smooth' });
    }

    previous.addEventListener('click', () => move(-1));
    next.addEventListener('click', () => move(1));
    track.addEventListener('scroll', updateControls, { passive: true });
    track.addEventListener('keydown', event => {
        if (event.target !== track) return;
        if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
            event.preventDefault();
            move(event.key === 'ArrowLeft' ? -1 : 1);
        } else if (event.key === 'Home' || event.key === 'End') {
            event.preventDefault();
            track.scrollTo({ left: event.key === 'Home' ? 0 : track.scrollWidth, behavior: reducedMotion.matches ? 'instant' : 'smooth' });
        }
    });

    if ('ResizeObserver' in window) new ResizeObserver(updateControls).observe(track);
    window.addEventListener('resize', updateControls);
    updateControls();
});
