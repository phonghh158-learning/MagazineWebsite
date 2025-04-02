const body = document.querySelector('body');

document.getElementById('theme').addEventListener('click', () => { 
    body.classList.toggle('dark');

    $theme = body.classList.contains('dark') ? 'dark' : '';

    document.cookie = "theme=" + $theme + "; path=/; max-age=" + (5 * 365 * 24 * 60 * 60);
});

function openModal() {
    document.getElementById("deleteModal").style.display = "block";
}

function closeModal() {
    document.getElementById("deleteModal").style.display = "none";
}

function confirmDelete() {
    alert("Bài viết đã bị xóa!");
    closeModal();
}
