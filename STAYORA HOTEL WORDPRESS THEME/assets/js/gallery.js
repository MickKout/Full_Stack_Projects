/**
 * Stayora — gallery.js
 * Masonry gallery, lightbox, accommodation gallery mosaic.
 */

'use strict';

/* =========================================================================
   Lightbox
========================================================================= */
class StayoraLightbox {
    constructor(images = []) {
        this.images  = images;
        this.current = 0;
        this.el      = document.getElementById('gallery-lightbox')
                    || document.getElementById('accommodation-lightbox');
        this.img     = document.getElementById('lightbox-img');
        this.counter = document.getElementById('lightbox-counter');
        this.init();
    }

    init() {
        if (!this.el) return;

        document.getElementById('lightbox-close')?.addEventListener('click', () => this.close());
        document.getElementById('lightbox-prev')?.addEventListener('click',  () => this.prev());
        document.getElementById('lightbox-next')?.addEventListener('click',  () => this.next());

        // Close on backdrop click
        this.el.addEventListener('click', (e) => {
            if (e.target === this.el) this.close();
        });

        // Keyboard nav
        document.addEventListener('keydown', (e) => {
            if (!this.el?.classList.contains('is-active')) return;
            if (e.key === 'Escape')     this.close();
            if (e.key === 'ArrowLeft')  this.prev();
            if (e.key === 'ArrowRight') this.next();
        });
    }

    open(index = 0) {
        this.current = index;
        this.show();
        this.el?.classList.add('is-active');
        document.body.style.overflow = 'hidden';
        this.el?.querySelector('.lightbox-img')?.focus();
    }

    close() {
        this.el?.classList.remove('is-active');
        document.body.style.overflow = '';
    }

    prev() {
        this.current = (this.current - 1 + this.images.length) % this.images.length;
        this.show();
    }

    next() {
        this.current = (this.current + 1) % this.images.length;
        this.show();
    }

    show() {
        const img = this.images[this.current];
        if (!img || !this.img) return;

        this.img.style.opacity = '0';
        this.img.src = typeof img === 'string' ? img : (img.src || img.url || img);
        this.img.alt = typeof img === 'object' ? (img.alt || '') : '';
        this.img.onload = () => {
            this.img.style.opacity = '1';
            this.img.style.transition = 'opacity 0.2s ease';
        };

        if (this.counter) {
            this.counter.textContent = `${this.current + 1} / ${this.images.length}`;
        }

        // Hide nav if single image
        const prev = document.getElementById('lightbox-prev');
        const next = document.getElementById('lightbox-next');
        const hide = this.images.length <= 1;
        if (prev) prev.style.display = hide ? 'none' : '';
        if (next) next.style.display = hide ? 'none' : '';
    }
}

/* =========================================================================
   Gallery Preview (homepage masonry)
========================================================================= */
const initMasonryGallery = () => {
    const grid = document.getElementById('gallery-preview-grid');
    if (!grid) return;

    const items  = Array.from(grid.querySelectorAll('.masonry-item'));
    const images = items.map(el => el.dataset.src || el.querySelector('img')?.src || '');

    const lb = new StayoraLightbox(images);

    items.forEach((item, i) => {
        item.addEventListener('click', () => lb.open(i));
        item.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); lb.open(i); }
        });
    });
};

/* =========================================================================
   Accommodation Gallery Mosaic
========================================================================= */
const initAccommodationGallery = () => {
    const dataEl = document.getElementById('accommodation-gallery-data');
    if (!dataEl) return;

    let images = [];
    try { images = JSON.parse(dataEl.textContent); } catch (e) { return; }

    const lb   = new StayoraLightbox(images);
    const items = document.querySelectorAll('.gallery-item');

    items.forEach((item, i) => {
        item.addEventListener('click', () => lb.open(i));
        item.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') lb.open(i);
        });
        item.setAttribute('tabindex', '0');
        item.setAttribute('role', 'button');
        item.setAttribute('aria-label', `View photo ${i + 1} of ${items.length}`);
    });

    // "View all photos" button
    document.getElementById('view-all-photos')?.addEventListener('click', () => lb.open(0));
};

/* =========================================================================
   Simple Image Slider (for room detail page header)
========================================================================= */
const initSlider = () => {
    document.querySelectorAll('[data-slider]').forEach(slider => {
        const slides = Array.from(slider.querySelectorAll('[data-slide]'));
        if (slides.length < 2) return;

        let current = 0;
        const dots  = slider.querySelectorAll('[data-dot]');

        const goTo = (index) => {
            slides[current].setAttribute('aria-hidden', 'true');
            slides[current].style.opacity = '0';
            dots[current]?.classList.remove('active');

            current = (index + slides.length) % slides.length;

            slides[current].setAttribute('aria-hidden', 'false');
            slides[current].style.opacity = '1';
            dots[current]?.classList.add('active');
        };

        // Arrow buttons
        slider.querySelector('[data-prev]')?.addEventListener('click', () => goTo(current - 1));
        slider.querySelector('[data-next]')?.addEventListener('click', () => goTo(current + 1));

        // Dots
        dots.forEach((dot, i) => dot.addEventListener('click', () => goTo(i)));

        // Auto-play (optional, pauses on hover)
        let timer = setInterval(() => goTo(current + 1), 5000);
        slider.addEventListener('mouseenter', () => clearInterval(timer));
        slider.addEventListener('mouseleave', () => { timer = setInterval(() => goTo(current + 1), 5000); });

        // Touch/swipe
        let startX = 0;
        slider.addEventListener('touchstart', (e) => { startX = e.touches[0].clientX; }, { passive: true });
        slider.addEventListener('touchend',   (e) => {
            const dx = e.changedTouches[0].clientX - startX;
            if (Math.abs(dx) > 50) goTo(dx < 0 ? current + 1 : current - 1);
        });

        goTo(0);
    });
};

/* =========================================================================
   Init
========================================================================= */
document.addEventListener('DOMContentLoaded', () => {
    initMasonryGallery();
    initAccommodationGallery();
    initSlider();
});
