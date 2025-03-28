const body = document.querySelector('body');

document.getElementById('theme').addEventListener('click', () => { 
    body.classList.toggle('dark');

    $theme = body.classList.contains('dark') ? 'dark' : '';

    document.cookie = "theme=" + $theme + "; path=/; max-age=" + (5 * 365 * 24 * 60 * 60);
});