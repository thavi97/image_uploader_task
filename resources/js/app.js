import './bootstrap';

document.querySelectorAll('input[type="checkbox"][data-persist]').forEach((checkbox) => {
    const key = `checkbox:${checkbox.dataset.persist}`;

    checkbox.checked = localStorage.getItem(key) === 'true';

    checkbox.addEventListener('change', () => {
        localStorage.setItem(key, checkbox.checked);
    });
});

document.addEventListener('submit', (event) => {
    const message = event.target.dataset.confirm;

    if (message && !confirm(message)) {
        event.preventDefault();
    }
});
