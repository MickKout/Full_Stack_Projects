/**
 * Stayora Theme — main.js
 * Core interactions: header, dark mode, scroll reveal, FAQ, mobile menu, parallax.
 * Pure vanilla JS — no jQuery dependency.
 */

'use strict';

/* =========================================================================
   Utility: debounce
========================================================================= */
const debounce = (fn, ms = 100) => {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => fn(...args), ms);
    };
};

/* =========================================================================
   1. Dark Mode Toggle
========================================================================= */
const initDarkMode = () => {
    const toggle = document.getElementById('theme-toggle');
    if (!toggle) return;

    const getTheme = () => localStorage.getItem('stayora_theme')
        || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

    const applyTheme = (theme) => {
        document.documentElement.setAttribute('data-theme', theme);
        document.documentElement.classList.toggle('dark', theme === 'dark');
        localStorage.setItem('stayora_theme', theme);
        document.cookie = `stayora_theme=${theme};path=/;max-age=31536000;SameSite=Lax`;
    };

    // Apply on load (also done inline in header to prevent FOFT)
    applyTheme(getTheme());

    toggle.addEventListener('click', () => {
        applyTheme(getTheme() === 'dark' ? 'light' : 'dark');
    });

    // Sync across tabs
    window.addEventListener('storage', (e) => {
        if (e.key === 'stayora_theme') applyTheme(e.newValue);
    });
};

/* =========================================================================
   2. Sticky Header + Transparent Hero Header
========================================================================= */
const initHeader = () => {
    const header  = document.getElementById('site-header');
    const isHero  = header?.dataset.hero === 'true';
    const bookBar = document.getElementById('booking-bar');
    const heroEl  = document.getElementById('hero');

    if (!header) return;

    const updateHeader = () => {
        const scrolled = window.scrollY > 60;

        if (isHero) {
            header.classList.toggle('is-scrolled',    scrolled);
            header.classList.toggle('is-transparent', !scrolled);
        }

        // Sticky nav links color on transparent header
        if (!scrolled && isHero) {
            header.querySelectorAll('a:not(.btn-primary):not(.btn-outline)').forEach(a => {
                a.style.color = 'rgba(255,255,255,0.9)';
            });
            header.querySelectorAll('#theme-toggle svg').forEach(el => {
                el.style.color = 'rgba(255,255,255,0.9)';
            });
        } else {
            header.querySelectorAll('a:not(.btn-primary):not(.btn-outline)').forEach(a => {
                a.style.color = '';
            });
            header.querySelectorAll('#theme-toggle svg').forEach(el => {
                el.style.color = '';
            });
        }

        // Show sticky booking bar after hero section
        if (bookBar && heroEl) {
            const heroBottom = heroEl.getBoundingClientRect().bottom;
            bookBar.classList.toggle('is-visible', heroBottom < 0);
            bookBar.setAttribute('aria-hidden', heroBottom >= 0 ? 'true' : 'false');
        }
    };

    window.addEventListener('scroll', updateHeader, { passive: true });
    updateHeader();
};

/* =========================================================================
   3. Mobile Menu
========================================================================= */
const initMobileMenu = () => {
    const toggleBtn = document.getElementById('mobile-menu-toggle');
    const closeBtn  = document.getElementById('mobile-close');
    const overlay   = document.getElementById('mobile-menu');
    const backdrop  = document.getElementById('mobile-backdrop');
    const drawer    = document.getElementById('mobile-drawer');
    const hamIcon   = toggleBtn?.querySelector('.hamburger-icon');
    const closeIcon = toggleBtn?.querySelector('.close-icon');

    if (!toggleBtn || !overlay) return;

    let isOpen = false;

    const open = () => {
        isOpen = true;
        overlay.classList.remove('pointer-events-none');
        overlay.setAttribute('aria-hidden', 'false');
        backdrop.style.opacity = '1';
        drawer.style.transform = 'translateX(0)';
        toggleBtn.setAttribute('aria-expanded', 'true');
        hamIcon?.classList.add('hidden');
        closeIcon?.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        // Focus first link
        drawer.querySelector('a, button')?.focus();
    };

    const close = () => {
        isOpen = false;
        backdrop.style.opacity = '0';
        drawer.style.transform = 'translateX(100%)';
        overlay.setAttribute('aria-hidden', 'true');
        toggleBtn.setAttribute('aria-expanded', 'false');
        hamIcon?.classList.remove('hidden');
        closeIcon?.classList.add('hidden');
        document.body.style.overflow = '';
        setTimeout(() => {
            if (!isOpen) overlay.classList.add('pointer-events-none');
        }, 300);
    };

    toggleBtn.addEventListener('click', () => isOpen ? close() : open());
    closeBtn?.addEventListener('click', close);
    backdrop?.addEventListener('click', close);

    // Close on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isOpen) close();
    });

    // Close on nav link click (mobile)
    drawer.querySelectorAll('a').forEach(a => a.addEventListener('click', close));
};

/* =========================================================================
   4. Scroll Reveal
========================================================================= */
const initScrollReveal = () => {
    const elements = document.querySelectorAll('.reveal');
    if (!elements.length) return;

    // Reduce motion support
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) {
        elements.forEach(el => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -40px 0px',
    });

    elements.forEach(el => observer.observe(el));
};

/* =========================================================================
   5. FAQ Accordion
========================================================================= */
const initFAQ = () => {
    const accordion = document.getElementById('faq-accordion');
    if (!accordion) return;

    accordion.querySelectorAll('.faq-question').forEach(btn => {
        btn.addEventListener('click', () => {
            const answer = document.getElementById(btn.getAttribute('aria-controls'));
            const icon   = btn.querySelector('.faq-icon');
            const isOpen = btn.getAttribute('aria-expanded') === 'true';

            // Close all
            accordion.querySelectorAll('.faq-question').forEach(b => {
                b.setAttribute('aria-expanded', 'false');
                document.getElementById(b.getAttribute('aria-controls'))?.classList.remove('is-open');
                b.querySelector('.faq-icon')?.classList.remove('is-open');
            });

            // Open clicked (if it was closed)
            if (!isOpen) {
                btn.setAttribute('aria-expanded', 'true');
                answer?.classList.add('is-open');
                icon?.classList.add('is-open');
            }
        });
    });
};

/* =========================================================================
   6. Hero Parallax
========================================================================= */
const initParallax = () => {
    const bg = document.getElementById('hero-parallax');
    if (!bg) return;

    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) return;

    const update = () => {
        const scrollY = window.scrollY;
        bg.style.transform = `translateY(${scrollY * 0.35}px)`;
    };

    window.addEventListener('scroll', update, { passive: true });
};

/* =========================================================================
   7. Smooth Scroll (anchor links)
========================================================================= */
const initSmoothScroll = () => {
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', (e) => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) {
                e.preventDefault();
                const headerH = parseInt(
                    getComputedStyle(document.documentElement).getPropertyValue('--header-height') || '80'
                );
                const y = target.getBoundingClientRect().top + window.scrollY - headerH - 16;
                window.scrollTo({ top: y, behavior: 'smooth' });
            }
        });
    });
};

/* =========================================================================
   8. Room Filter Tabs (homepage)
========================================================================= */
const initRoomFilterTabs = () => {
    const tabs = document.getElementById('room-filter-tabs');
    const grid = document.getElementById('rooms-grid');
    if (!tabs || !grid) return;

    tabs.querySelectorAll('button[data-filter]').forEach(btn => {
        btn.addEventListener('click', () => {
            // Update active state
            tabs.querySelectorAll('button').forEach(b => {
                b.classList.remove('badge-gold');
                b.classList.add('badge');
                b.setAttribute('aria-selected', 'false');
            });
            btn.classList.remove('badge');
            btn.classList.add('badge-gold');
            btn.setAttribute('aria-selected', 'true');

            const filter = btn.dataset.filter;
            if (filter === 'all') {
                // Reload — show all
                fetchRooms({ room_type: '' });
            } else {
                fetchRooms({ room_type: filter });
            }
        });
    });
};

const fetchRooms = async (params = {}) => {
    const grid    = document.getElementById('rooms-grid');
    const loading = document.getElementById('rooms-loading');
    if (!grid || !window.stayora) return;

    loading?.classList.remove('hidden');
    grid.style.opacity = '0.4';

    const body = new URLSearchParams({
        action: 'stayora_filter_rooms',
        nonce:  stayora.nonce,
        ...params,
    });

    try {
        const res  = await fetch(stayora.ajaxUrl, { method: 'POST', body, headers: { 'Content-Type': 'application/x-www-form-urlencoded' } });
        const data = await res.json();
        if (data.success) {
            grid.innerHTML = data.data.html;
            initScrollReveal();
        }
    } catch (e) {
        console.error('Stayora: room filter error', e);
    } finally {
        loading?.classList.add('hidden');
        grid.style.opacity = '1';
    }
};

/* =========================================================================
   9. Archive Room Filters
========================================================================= */
const initArchiveFilters = () => {
    const sortSel   = document.getElementById('sort-rooms');
    const typeSel   = document.getElementById('filter-room-type');
    const guestsSel = document.getElementById('filter-guests');

    const applyFilters = debounce(() => {
        fetchRooms({
            room_type: typeSel?.value || '',
            guests:    guestsSel?.value || '',
            orderby:   sortSel?.value  || 'date',
        });
    }, 300);

    sortSel?.addEventListener('change', applyFilters);
    typeSel?.addEventListener('change', applyFilters);
    guestsSel?.addEventListener('change', applyFilters);
};

/* =========================================================================
   10. Guest Counter Buttons
========================================================================= */
const initGuestCounters = () => {
    document.querySelectorAll('.guest-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.target;
            const form   = btn.closest('form');
            if (!form) return;

            const input = form.querySelector(`[name="${target}"]`);
            if (!input) return;

            const min = parseInt(input.min || 0);
            const max = parseInt(input.max || 99);
            let val   = parseInt(input.value || 0);

            if (btn.classList.contains('plus'))  val = Math.min(val + 1, max);
            if (btn.classList.contains('minus')) val = Math.max(val - 1, min);

            input.value = val;
            input.dispatchEvent(new Event('change'));
        });
    });
};

/* =========================================================================
   11. Price Preview (booking widget)
========================================================================= */
const initPricePreview = () => {
    document.querySelectorAll('.booking-enquiry-form').forEach(form => {
        const postId     = form.dataset.postId;
        const checkin    = form.querySelector('[name="checkin"]');
        const checkout   = form.querySelector('[name="checkout"]');
        const preview    = document.getElementById(`price-preview-${postId}`);
        const nightsLbl  = document.getElementById(`nights-label-${postId}`);
        const nightsCost = document.getElementById(`nights-cost-${postId}`);
        const totalCost  = document.getElementById(`total-cost-${postId}`);

        if (!checkin || !checkout || !preview) return;

        const currency = window.stayora?.currency || '€';
        const priceEl  = form.closest('[id^="booking-widget"]')?.querySelector('.price-value');
        const priceStr = priceEl?.textContent?.replace(/[^\d]/g, '');
        const priceNight = parseInt(priceStr || 0);

        const update = () => {
            const ci = new Date(checkin.value);
            const co = new Date(checkout.value);
            if (!checkin.value || !checkout.value || co <= ci) {
                preview.classList.add('hidden');
                return;
            }
            const nights = Math.round((co - ci) / 86400000);
            if (nights < 1 || !priceNight) { preview.classList.add('hidden'); return; }

            const total = nights * priceNight;
            nightsLbl.textContent  = `${nights} ${nights === 1 ? 'night' : 'nights'} × ${currency}${priceNight.toLocaleString()}`;
            nightsCost.textContent = `${currency}${total.toLocaleString()}`;
            totalCost.textContent  = `${currency}${total.toLocaleString()}`;
            preview.classList.remove('hidden');

            // Enforce min checkout
            checkout.min = checkin.value;
        };

        checkin.addEventListener('change', update);
        checkout.addEventListener('change', update);
    });
};

/* =========================================================================
   12. Newsletter Form (footer)
========================================================================= */
const initNewsletter = () => {
    const form = document.getElementById('footer-newsletter');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const email  = form.querySelector('[name="email"]')?.value;
        const btn    = form.querySelector('button[type="submit"]');
        if (!email) return;

        const origText = btn.textContent;
        btn.textContent = '…';
        btn.disabled    = true;

        // Simulate success (hook to your email service in production)
        await new Promise(r => setTimeout(r, 800));

        btn.textContent = '✓ Subscribed';
        btn.style.backgroundColor = 'var(--color-text)';
        form.querySelector('[name="email"]').value = '';

        setTimeout(() => {
            btn.textContent = origText;
            btn.disabled    = false;
            btn.style.backgroundColor = '';
        }, 4000);
    });
};

/* =========================================================================
   Init
========================================================================= */
document.addEventListener('DOMContentLoaded', () => {
    initDarkMode();
    initHeader();
    initMobileMenu();
    initScrollReveal();
    initFAQ();
    initParallax();
    initSmoothScroll();
    initRoomFilterTabs();
    initArchiveFilters();
    initGuestCounters();
    initPricePreview();
    initNewsletter();
});
