document.addEventListener('DOMContentLoaded', function() {
    let mailtoLinkWrapper = document.querySelector('#mailToLink');
    let mailtoLink = mailtoLinkWrapper.dataset.mailtoLink;
    if(mailtoLink !== '')
    {
        modalWindow.style.opacity = ''
        modalWindow.style.display = 'block';
    }

});

let copyLinkBtn = document.querySelector('#copy-link-btn');
let saveLinkBtn = document.querySelector('#save-link-btn');
copyLinkBtn.onclick = (e) =>
{
    e.preventDefault();
    copyData(copyLinkBtn.parentElement.parentElement.firstElementChild);
}

saveLinkBtn.onclick = (e) =>
{
    e.preventDefault();
    saveData(saveLinkBtn.parentElement.parentElement.firstElementChild);
}
