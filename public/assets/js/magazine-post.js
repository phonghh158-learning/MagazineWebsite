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

