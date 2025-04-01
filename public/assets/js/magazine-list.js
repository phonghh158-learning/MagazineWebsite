// if (document.getElementById('page').value = "") {
//     document.getElementById('page').value = 1;
// }

const currentPage = document.getElementById('page');
if (currentPage.value == "") {
    currentPage.removeAttribute('value');
    currentPage.value = 1;
}

