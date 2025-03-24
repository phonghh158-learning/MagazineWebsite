const body = document.querySelector('body');

document.getElementById('theme').addEventListener('click', () => { 
    body.classList.toggle('dark');
});