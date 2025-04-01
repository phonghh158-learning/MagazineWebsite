const ratingInput = document.getElementById('rating');
const ratingStars = document.querySelectorAll('.rating-star');
const sunmitButton = document.getElementById('review-submit');

let ratingValue = 0;

setDisabledSubmitButton(ratingValue);

function setDisabledSubmitButton(val) {
    if (val == 0) {
        sunmitButton.disabled = true;
    } else {
        sunmitButton.disabled = false;
    }
}

ratingStars.forEach((star, index) => {
    star.addEventListener('click', () => {
        ratingValue = index + 1;
        ratingInput.value = ratingValue;
        setDisabledSubmitButton(ratingValue);

        for (let i = 1; i <= ratingValue; i++) {
            ratingStars[i - 1].classList.remove('bx-star');
            ratingStars[i - 1].classList.add('bxs-star');
        }

        for (let i = ratingValue + 1; i <= 5; i++) {
            ratingStars[i - 1].classList.remove('bxs-star');
            ratingStars[i - 1].classList.add('bx-star');
        }
    })
})

let yourRatingValue = document.getElementById('your-rating-value').textContent;

for (let i = 1; i <= parseInt(yourRatingValue); i++) {
    document.getElementById('rating-' + i).classList.remove('bx-star');
    document.getElementById('rating-' + i).classList.add('bxs-star');
}


const btnDelete = document.getElementById('btn-delete');

btnDelete.addEventListener('click', () => {
    let res = prompt();
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

// const thumbnailInput = document.getElementById('thumbnail');
// thumbnailInput.addEventListener('click', () => { 
//     if (thumbnailInput.files.length > 0) {
//         alert("Tệp đã được chọn: " + fileInput.files[0].name);
//     }
// })