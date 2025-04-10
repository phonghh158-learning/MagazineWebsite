const ratingInput = document.getElementById('rating');
const ratingStars = document.querySelectorAll('.rating-star');
const submitButton = document.getElementById('review-submit');

let ratingValue = 0;

setDisabledSubmitButton(ratingValue);

function setDisabledSubmitButton(val) {
    if (val == 0) {
        submitButton.disabled = true;
    } else {
        submitButton.disabled = false;
    }
}

ratingStars.forEach((star, index) => {
    star.addEventListener('click', () => {
        ratingValue = index + 1;
        ratingInput.removeAttribute("value");
        ratingInput.setAttribute("value", ratingValue);
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

let yourRatingText = document.getElementById('your-rating-text').textContent;
switch (yourRatingValue) {
    case '1':
        yourRatingText = 'Dở';
        break;
    case '2':
        yourRatingText = 'Khá tệ';
        break;
    case '3':
        yourRatingText = 'Tạm được';
        break;
    case '4':
        yourRatingText = 'Hay';
        break;
    case '5':
        yourRatingText = 'Xuất sắc';
        break;
    default:
        yourRatingText = 'Khó đoán';
        break;
}

// Modal - Update Review


function openEditReviewModal(postId, reviewId, oldText, oldRating) {
    const editReviewOverlay = document.getElementById('edit-review-overlay');
    const editReviewForm = document.getElementById('edit-review-form');
    const editSubmitBtn = document.getElementById('edit-review-submit');
    const editReviewText = document.getElementById('edit-review-text');
    const editRatingInput = document.getElementById('edit-rating');
    editReviewText.value = oldText;
    editRatingInput.removeAttribute("value");
    editRatingInput.setAttribute("value", parseInt(oldRating));

    for (let i = 1; i <= parseInt(oldRating); i++) {
        document.getElementById('edit-rating-' + i).classList.remove('bx-star');
        document.getElementById('edit-rating-' + i).classList.add('bxs-star');
    }

    const ratingStars = document.querySelectorAll('.rating-star');
    let ratingValue = parseInt(oldRating);
    ratingStars.forEach((star, index) => {
        star.addEventListener('click', () => {
            ratingValue = index + 1;
            editRatingInput.removeAttribute("value");
            editRatingInput.setAttribute("value", ratingValue);

            for (let i = 1; i <= ratingValue; i++) {
                ratingStars[i - 1].classList.remove('bx-star');
                ratingStars[i - 1].classList.add('bxs-star');
            }

            for (let i = ratingValue + 1; i <= 5; i++) {
                ratingStars[i - 1].classList.remove('bxs-star');
                ratingStars[i - 1].classList.add('bx-star');
            }
        });
    });

    editReviewForm.action = `/news/${postId}/review/${reviewId}/update`;

    editSubmitBtn.disabled = false;
    editReviewOverlay.style.display = 'flex';
}

function closeEditReviewModal() {
    const editReviewOverlay = document.getElementById('edit-review-overlay');
    const editReviewForm = document.getElementById('edit-review-form');
    const editSubmitBtn = document.getElementById('edit-review-submit');
    const editStars = document.querySelectorAll('#edit-review-stars .rating-star');
    editReviewOverlay.style.display = 'none';
    editReviewForm.reset();
    editReviewForm.action = '';
    editStars.forEach(star => star.classList.remove('bxs-star', 'bx'));
    editStars.forEach(star => star.classList.add('bx-star'));
    editSubmitBtn.disabled = true;
}

//Delete Review

function openDeleteReviewModal(postId, reviewId) {
    const deleteReviewOverlay = document.getElementById('delete-review-overlay');
    const deleteReviewForm = document.getElementById('delete-review-form');
    deleteReviewOverlay.style.display = 'flex';
    deleteReviewForm.action = `/news/${postId}/review/${reviewId}/delete`;
}

function closeDeleteReviewModal() {
    const deleteReviewOverlay = document.getElementById('delete-review-overlay');
    const deleteReviewForm = document.getElementById('delete-review-form');
    deleteReviewOverlay.style.display = 'none';
    deleteReviewForm.reset();
    deleteReviewForm.action = '';
}
