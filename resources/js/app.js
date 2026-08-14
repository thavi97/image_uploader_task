import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';

AOS.init({ duration: 300, once: true });

document.querySelectorAll('input[type="checkbox"][data-persist]').forEach((checkbox) => {
    const key = `checkbox:${checkbox.dataset.persist}`;

    checkbox.checked = localStorage.getItem(key) === 'true';

    checkbox.addEventListener('change', () => {
        localStorage.setItem(key, checkbox.checked);
    });
});

// Image lightbox popup (see the <dialog> in the app layout for the markup).
const lightbox = document.getElementById('image-lightbox');
const lightboxImg = document.getElementById('image-lightbox-img');

document.addEventListener('click', (event) => {
    // Clicking a thumbnail opens the lightbox with that image.
    const trigger = event.target.closest('[data-lightbox]');

    if (trigger) {
        lightboxImg.src = trigger.dataset.lightbox;
        lightbox.showModal();
        return;
    }

    // Clicking the close button closes it.
    if (event.target.closest('[data-lightbox-close]')) {
        lightbox.close();
    }
});

// Clicking the dimmed backdrop also closes it. When showModal() is used, a click
// directly on the <dialog> element (rather than one of its children) means the
// backdrop was clicked, since the dialog's own box only covers its content.
lightbox?.addEventListener('click', (event) => {
    if (event.target === lightbox) {
        lightbox.close();
    }
});

// Clear the image on close (covers the backdrop/Escape-key paths too) so the old
// image doesn't flash briefly the next time the lightbox opens.
lightbox?.addEventListener('close', () => {
    lightboxImg.src = '';
});

document.addEventListener('submit', (event) => {
    const message = event.target.dataset.confirm;

    if (message && !confirm(message)) {
        event.preventDefault();
    }
});
