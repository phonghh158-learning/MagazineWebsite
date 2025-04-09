const body = document.querySelector('body');

document.getElementById('theme').addEventListener('click', () => { 
    body.classList.toggle('dark');

    $theme = body.classList.contains('dark') ? 'dark' : '';

    document.cookie = "theme=" + $theme + "; path=/; max-age=" + (5 * 365 * 24 * 60 * 60);
});

// Notification
let timeoutId;

function showNotification(message, color = '#4caf50') {
    const popup = document.getElementById('notification-popup');
    const msg = document.getElementById('notification-message');
    const progress = document.getElementById('notification-progress');

    progress.style.backgroundColor = color;
    popup.style.border = `1px solid ${color}`;
    msg.textContent = message;

    // Reset animation
    const newProgress = progress.cloneNode(true);
    progress.parentNode.replaceChild(newProgress, progress);

    popup.classList.remove('hidden');
    popup.classList.add('show');

    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => {
        hideNotification();
    }, 5000);
}

function hideNotification() {
    const popup = document.getElementById('notification-popup');
    popup.classList.add('hidden');
    popup.classList.remove('show');
}


// Modal - Delete
const overlay = document.getElementById('modal-overlay');
const deleteForm = document.getElementById('delete-form');

function openDeleteModal(id, route) {
    overlay.style.display = 'flex';
    deleteForm.action = `/${route}/delete/${id}`;
}

function closeDeleteModal() {
    overlay.style.display = 'none';
    deleteForm.reset();
    deleteForm.action = '';
}
