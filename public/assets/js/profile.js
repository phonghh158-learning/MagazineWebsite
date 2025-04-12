const profileBar = document.getElementById('profile-bar');
const menuButton = document.getElementById('menu-button');

menuButton.addEventListener('click', () => {
    profileBar.classList.toggle('extend');

    const profileBarLink = document.querySelectorAll('.profile-bar-link');
    if (profileBar.classList.contains('extend')) {
        let positon = 0;
        let transitionTime = 0.5;
        profileBarLink.forEach(link => {
            link.style.transition = 'opacity ' + transitionTime + 's ease-in';
            link.style.top = positon + 'px';
            positon += 56;
            transitionTime = transitionTime + 0.75;
        });
    } else {
        let transitionTime = 1.1;
        let acceleration = 0;
        profileBarLink.forEach(link => {
            link.style.transition = 'all ' + transitionTime + 's ease';
            transitionTime = transitionTime - 0.4 + acceleration;
            acceleration += 0.1;
        });
    }
});

document.getElementById('avatar-image').src === '' 
? document.getElementById('avatar-image').alt = 'Chưa có avatar' 
: document.getElementById('avatar-image').alt = 'Profile Avatar';

const profileFnButton = document.getElementById('profile-function');

profileFnButton.addEventListener('click', () => {
    let profileFnButtonIcon = profileFnButton.querySelector('i');
    let profileFnButtonName = profileFnButton.querySelector('p');

    const profileSection = document.getElementById('profile');
    profileSection.classList.toggle('edit');

    let avatarUpload = document.getElementById('avatar-upload');
    let iconTo = document.getElementById('icon-to');

    let profileButtons = document.querySelectorAll('.profile-buttons');

    let profileInformationInput = document.querySelectorAll('.profile-information input');

    if (profileSection.classList.contains('edit')) {
        profileFnButtonIcon.classList.add('bx-show');
        profileFnButtonIcon.classList.remove('bx-edit');
        profileFnButtonName.textContent = 'Xem';

        avatarUpload.style.display = 'flex';
        iconTo.style.display = 'flex';

        profileButtons.forEach(button => {
            button.style.display = 'flex';
        })

        profileInformationInput.forEach(input => {
            input.removeAttribute('readonly');
        });

    } else {
        location.reload();
    }
});

function handleAvatarChange(inputElement) {
    const avatarPreview = document.getElementById('avatar-update');
    const avatarBox = document.querySelector('.avatar-box');

    const file = inputElement.files[0];

    if (file) {
        const allowedExtensions = ['image/png', 'image/jpeg', 'image/jpg'];
        if (!allowedExtensions.includes(file.type)) {
            alert('Chỉ chấp nhận file PNG, JPG, hoặc JPEG!');
            resetAvatar(inputElement, avatarPreview, avatarBox);
            return;
        }

        if (file.size > 4 * 1024 * 1024) { // 4MB
            alert("File quá lớn! Chỉ chấp nhận file tối đa 4MB.");
            resetAvatar(inputElement, avatarPreview, avatarBox);
            return;
        }

        const fileURL = URL.createObjectURL(file);
        avatarPreview.src = fileURL;
        avatarPreview.style.display = 'block';
        avatarBox.style.display = 'none';
    }
}