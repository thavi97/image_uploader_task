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

const lightbox = document.getElementById('image-lightbox');
const lightboxImg = document.getElementById('image-lightbox-img');

document.addEventListener('click', (event) => {
    const trigger = event.target.closest('[data-lightbox]');

    if (trigger) {
        lightboxImg.src = trigger.dataset.lightbox;
        lightbox.showModal();
        return;
    }

    if (event.target.closest('[data-lightbox-close]')) {
        lightbox.close();
    }
});

lightbox?.addEventListener('click', (event) => {
    if (event.target === lightbox) {
        lightbox.close();
    }
});

lightbox?.addEventListener('close', () => {
    lightboxImg.src = '';
});

document.addEventListener('submit', (event) => {
    const message = event.target.dataset.confirm;

    if (message && !confirm(message)) {
        event.preventDefault();
    }
});
