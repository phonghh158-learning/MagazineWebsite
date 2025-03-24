const content = document.getElementById('content');
const addParaButton = document.getElementById('add-paragraph');
const deleteParaButton = document.getElementById('delete-paragraph');

let paragraphNumber = 1;

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
    let paragraphImage = document.createElement('input');
    let paragraphTitle = document.createElement('input');
    let paragraphContent = document.createElement('textarea');

    paragraph.classList.add('paragraph');
    paragraph.id = 'paragraph-' + paraNumber;

    paragraphImage.classList.add('paragraph-image');
    paragraphImage.setAttribute('type', 'file');
    paragraphImage.setAttribute('name', 'paragraph-image');
    paragraphImage.setAttribute('accept', 'image/*');

    paragraphTitle.classList.add('paragraph-title');
    paragraphTitle.setAttribute('type', 'text');
    paragraphTitle.setAttribute('name', 'title');
    paragraphTitle.setAttribute('id', 'title');
    paragraphTitle.setAttribute('placeholder', 'Tiêu đề đoạn văn');

    paragraphContent.classList.add('paragraph-content');
    paragraphContent.setAttribute('name', 'paragraph-content');
    paragraphContent.setAttribute('id', 'paragraph-content');
    paragraphContent.setAttribute('cols', '30');
    paragraphContent.setAttribute('rows', '10');
    paragraphContent.setAttribute('placeholder', 'Nội dung đoạn văn');

    paragraph.appendChild(paragraphImage);
    paragraph.appendChild(paragraphTitle);
    paragraph.appendChild(paragraphContent);

    return paragraph;
}