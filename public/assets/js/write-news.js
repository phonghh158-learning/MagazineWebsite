const content = document.getElementById('content');
const addParaButton = document.getElementById('add-paragraph');
const deleteParaButton = document.getElementById('delete-paragraph');
const paragraphs = document.getElementsByClassName('paragraph');

let paragraphNumber = paragraphs.length;

setVisibilityDeleteButton(paragraphNumber);

addParaButton.addEventListener('click', () => {
    paragraphNumber++;
    let paragraph = createParagraph(paragraphNumber);
    content.appendChild(paragraph);

    setVisibilityDeleteButton(paragraphNumber);
});

deleteParaButton.addEventListener('click', () => {
    if (paragraphNumber >= 1) {
        let paragraph = document.getElementById('paragraph-' + paragraphNumber);
        content.removeChild(paragraph);
    } else {
        paragraphNumber = 1;
    }
    
    paragraphNumber--;

    setVisibilityDeleteButton(paragraphNumber);
});

function setVisibilityDeleteButton(paraNumber) {
    if (paraNumber > 1) {
        deleteParaButton.style.display = 'flex';
    } else {
        deleteParaButton.style.display = 'none';
    }
}

function createParagraph(paraNumber) {
    let paragraph = document.createElement('div');
    let paragraphTitle = document.createElement('input');
    let paragraphContent = document.createElement('textarea');

    paragraph.classList.add('paragraph');
    paragraph.id = 'paragraph-' + paraNumber;

    paragraphTitle.classList.add('paragraph-title');
    paragraphTitle.setAttribute('type', 'text');
    paragraphTitle.setAttribute('name', 'paragraph_title[]');
    paragraphTitle.setAttribute('id', 'paragraph-title');
    paragraphTitle.setAttribute('placeholder', 'Tiêu đề đoạn văn');
    paragraphTitle.setAttribute('required', '');

    paragraphContent.classList.add('paragraph-content');
    paragraphContent.setAttribute('name', 'paragraph_content[]');
    paragraphContent.setAttribute('id', 'paragraph-content');
    paragraphContent.setAttribute('cols', '30');
    paragraphContent.setAttribute('rows', '10');
    paragraphContent.setAttribute('placeholder', 'Nội dung đoạn văn');
    paragraphContent.setAttribute('required', '');

    paragraph.appendChild(paragraphTitle);
    paragraph.appendChild(paragraphContent);

    return paragraph;
}

const thumbnailInput = document.getElementById("thumbnail");
const currentThumbnail = thumbnailInput.style.backgroundImage ?? null;

thumbnailInput.addEventListener("change", function () {
    if (thumbnailInput.files.length > 0) {
        const file = thumbnailInput.files[0];
        const fileURL = URL.createObjectURL(file);

        const allowedExtensions = ['image/png', 'image/jpeg', 'image/jpg'];
        if (!allowedExtensions.includes(file.type)) {
            alert('Chỉ chấp nhận file PNG, JPG, hoặc JPEG!');
            thumbnailInput.value = '';
            thumbnailInput.style.backgroundImage = currentThumbnail;
        } else {
            // Cập nhật hình nền
            thumbnailInput.style.backgroundImage = `url(${fileURL})`;
        }

        if (file.size > 4 * 1024 * 1024) { // 4MB
            alert("File quá lớn! Chỉ chấp nhận file tối đa 4MB.");
            thumbnailInput.value = "";
            thumbnailInput.style.backgroundImage = currentThumbnail;
        }
    } else {
        // Cập nhật hình nền
        thumbnailInput.style.backgroundImage = currentThumbnail;
    }
});