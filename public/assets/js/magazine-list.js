// if (document.getElementById('page').value = "") {
//     document.getElementById('page').value = 1;
// }

const currentPage = document.getElementById('page');
if (currentPage.value == "") {
    currentPage.removeAttribute('value');
    currentPage.value = 1;
}

document.getElementById("search-input").addEventListener("focus", function(event) {
    this.placeholder = "Nhập từ khóa...";
});
document.getElementById("search-input").addEventListener("focusout", function(event) {
    this.placeholder = "Tìm kiếm tiêu đề bài báo";
});

