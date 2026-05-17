/**
 * Stayora — booking.js
 * Handles booking form AJAX submission and hero search form redirect.
 */

'use strict';

/* =========================================================================
   Booking Enquiry Form AJAX Submit
========================================================================= */
const initBookingForms = () => {
    document.querySelectorAll('.booking-enquiry-form').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn  = form.querySelector('.booking-submit-btn');
            const msgEl      = form.querySelector('.booking-response');
            const origText   = submitBtn.innerHTML;

            // Validation
            const required = form.querySelectorAll('[required]');
            let valid = true;
            required.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = '#e53e3e';
                    valid = false;
                } else {
                    field.style.borderColor = '';
                }
            });
            if (!valid) {
                showMsg(msgEl, window.stayora?.i18n?.loading || 'Please fill all required fields.', 'error');
                return;
            }

            // Loading state
            submitBtn.innerHTML = '<svg class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"/><path d="M12 2a10 10 0 0 1 10 10" /></svg> Sending…';
            submitBtn.disabled = true;

            const data = new URLSearchParams(new FormData(form));

            try {
                const res    = await fetch(window.stayora?.ajaxUrl || '/wp-admin/admin-ajax.php', {
                    method:  'POST',
                    body:    data,
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                });
                const result = await res.json();

                if (result.success) {
                    showMsg(msgEl, result.data.message, 'success');
                    form.reset();
                    document.getElementById(`price-preview-${form.dataset.postId}`)?.classList.add('hidden');
                } else {
                    showMsg(msgEl, result.data.message || 'Something went wrong.', 'error');
                }
            } catch (err) {
                showMsg(msgEl, 'Network error. Please try again.', 'error');
            } finally {
                submitBtn.innerHTML = origText;
                submitBtn.disabled  = false;
            }
        });
    });
};

const showMsg = (el, text, type) => {
    if (!el) return;
    el.textContent = text;
    el.style.color = type === 'success' ? 'var(--color-secondary)' : '#e53e3e';
    el.classList.remove('hidden');
    if (type === 'success') setTimeout(() => el.classList.add('hidden'), 6000);
};

/* =========================================================================
   Hero Search Form → Redirect
========================================================================= */
const initHeroSearchForm = () => {
    const form = document.getElementById('hero-booking-form');
    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const checkin   = form.querySelector('[name="checkin"]')?.value;
        const checkout  = form.querySelector('[name="checkout"]')?.value;
        const guests    = form.querySelector('[name="guests"]')?.value;
        const roomType  = form.querySelector('[name="room_type"]')?.value;

        const archiveUrl = window.stayora?.siteUrl
            ? `${window.stayora.siteUrl}/accommodations/`
            : '/accommodations/';

        const params = new URLSearchParams();
        if (checkin)   params.set('checkin',    checkin);
        if (checkout)  params.set('checkout',   checkout);
        if (guests)    params.set('guests',     guests);
        if (roomType)  params.set('room_type',  roomType);

        window.location.href = `${archiveUrl}?${params.toString()}`;
    });
};

/* =========================================================================
   Pre-fill forms from URL params (archive/search redirect)
========================================================================= */
const prefillFromURL = () => {
    const params = new URLSearchParams(window.location.search);
    const map = {
        checkin:   '[name="checkin"]',
        checkout:  '[name="checkout"]',
        guests:    '[name="guests"]',
        room_type: '[name="room_type"]',
    };

    Object.entries(map).forEach(([key, sel]) => {
        const val = params.get(key);
        if (!val) return;
        document.querySelectorAll(sel).forEach(el => {
            el.value = val;
            el.dispatchEvent(new Event('change'));
        });
    });
};

/* =========================================================================
   Init
========================================================================= */
document.addEventListener('DOMContentLoaded', () => {
    initBookingForms();
    initHeroSearchForm();
    prefillFromURL();
});
