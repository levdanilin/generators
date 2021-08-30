document.addEventListener('DOMContentLoaded', function() {
    let passwordWrapper = document.querySelector('#password');
    let password = passwordWrapper.dataset.password;
    if (password !== '') {
        modalWindow.style.opacity = ''
        modalWindow.style.display = 'block';
    }
})

let copyPasswordBtn = document.querySelector('#copy-password-btn');
let savePasswordBtn = document.querySelector('#save-password-btn');
copyPasswordBtn.onclick = (e) =>
{
    e.preventDefault();
    copyData(copyPasswordBtn.parentElement.parentElement.firstElementChild);
}

savePasswordBtn.onclick = (e) =>
{
    e.preventDefault();
    saveData(savePasswordBtn.parentElement.parentElement.firstElementChild);
}
