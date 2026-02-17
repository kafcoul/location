/**
 * CKF Motors — Vehicle Page JavaScript
 * Carousel + reveal animations
 */
document.addEventListener('DOMContentLoaded', () => {

    /* ── Carousel ── */
    const gallery = document.getElementById('vehicleGallery');
    if (gallery) {
        const images = gallery.querySelectorAll('.vp-gallery__img');
        const dots   = gallery.querySelectorAll('.vp-gallery__dot');
        const arrows = gallery.querySelectorAll('.vp-gallery__arrow');
        let current  = 0;
        let autoTimer;

        const goTo = (index) => {
            if (images.length === 0) return;
            current = (index + images.length) % images.length;
            images.forEach(img => img.classList.remove('is-active'));
            dots.forEach(dot => dot.classList.remove('is-active'));
            images[current].classList.add('is-active');
            if (dots[current]) dots[current].classList.add('is-active');
        };

        // Arrow clicks
        arrows.forEach(btn => {
            btn.addEventListener('click', () => {
                goTo(btn.dataset.dir === 'next' ? current + 1 : current - 1);
                resetAuto();
            });
        });

        // Dot clicks
        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                goTo(parseInt(dot.dataset.index, 10));
                resetAuto();
            });
        });

        // Keyboard
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') { goTo(current + 1); resetAuto(); }
            if (e.key === 'ArrowLeft')  { goTo(current - 1); resetAuto(); }
        });

        // Touch swipe
        let touchStartX = 0;
        const viewport = gallery.querySelector('.vp-gallery__viewport');
        if (viewport) {
            viewport.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            viewport.addEventListener('touchend', (e) => {
                const diff = touchStartX - e.changedTouches[0].screenX;
                if (Math.abs(diff) > 50) {
                    goTo(diff > 0 ? current + 1 : current - 1);
                    resetAuto();
                }
            }, { passive: true });
        }

        // Auto-advance
        const startAuto = () => {
            autoTimer = setInterval(() => goTo(current + 1), 6000);
        };
        const resetAuto = () => {
            clearInterval(autoTimer);
            startAuto();
        };

        if (images.length > 1) {
            startAuto();
            gallery.addEventListener('mouseenter', () => clearInterval(autoTimer));
            gallery.addEventListener('mouseleave', () => startAuto());
        }
    }

    /* ── Description sections reveal ── */
    const descSections = document.querySelectorAll('.vp-description__section');
    if (descSections.length > 0 && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -40px 0px'
        });

        descSections.forEach((el, i) => {
            el.style.transitionDelay = `${i * 0.12}s`;
            el.classList.add('v-reveal-ready');
            observer.observe(el);
        });

        // Fallback: reveal all after 2s
        setTimeout(() => {
            descSections.forEach(el => {
                if (!el.classList.contains('is-visible')) {
                    el.classList.add('is-visible');
                }
            });
        }, 2000);
    }

    /* ── Generic reveal elements ── */
    const revealEls = document.querySelectorAll('.v-reveal');
    if (revealEls.length > 0) {
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.06,
            rootMargin: '0px 0px -50px 0px'
        });

        revealEls.forEach(el => revealObserver.observe(el));
    }
});
