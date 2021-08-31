document.addEventListener('DOMContentLoaded', function() {
    let basicAuthDataWrapper = document.querySelector('#data-password');
    let verifyStatus = basicAuthDataWrapper.dataset.verifyStatus;
    if (verifyStatus === '1') {
        modalWindow.style.opacity = ''
        modalWindow.style.display = 'block';
    }
})

const downloadToFile = (content, filename, contentType) => {
    const a = document.createElement('a');
    const file = new Blob([content], {type: contentType});

    a.href= URL.createObjectURL(file);
    a.download = filename;

    if(!confirm("save all?"))
    {
        return;
    }

    a.click();

    URL.revokeObjectURL(a.href);
};

document.querySelector('#save-allData-btn').addEventListener('click', () => {
    let dataAccessInnerText = document.querySelector("#data-access").innerText;
    let dataPasswordElements = document.querySelectorAll("#data-password");
    let dataPasswordInnerText = '';

    dataPasswordElements.forEach(dataPasswordElement => {
            dataPasswordInnerText += dataPasswordElement.firstElementChild.innerText + '\n';
        }
    )

    let allData = dataAccessInnerText + dataPasswordInnerText;
    downloadToFile(allData, 'all-data.txt', 'text/plain');
});


let passwordDataCopyButtons = document.querySelectorAll('#copy-passwordData-btn');
let passwordDataSaveButtons = document.querySelectorAll('#save-passwordData-btn');
let accessDataCopyButton = document.querySelector('#copy-accessData-btn');
let accessDataSaveButton = document.querySelector('#save-accessData-btn');

passwordDataCopyButtons.forEach(passwordDataCopyButton => passwordDataCopyButton.addEventListener('click',(e) => {
            e.preventDefault();
            copyData(passwordDataCopyButton.parentElement.parentElement.firstElementChild);
        }
    )
)

passwordDataSaveButtons.forEach(passwordDataSaveButton => passwordDataSaveButton.addEventListener('click',(e) => {
        e.preventDefault();
        saveData(passwordDataSaveButton.parentElement.parentElement.firstElementChild);
    }
))

accessDataCopyButton.onclick = (e) =>
{
    e.preventDefault();
    copyData(accessDataCopyButton.parentElement.parentElement.firstElementChild);
}

accessDataSaveButton.onclick = (e) =>
{
    e.preventDefault();
    saveData(accessDataSaveButton.parentElement.parentElement.firstElementChild);
}

const addFormToCollection = (e) => {
    const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

    const item = document.createElement('li');
    item.classList.add('new-user')

    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            collectionHolder.dataset.index
        );

    collectionHolder.appendChild(item);

    collectionHolder.dataset.index++;
    addTagFormDeleteLink(item);
}

const addTagFormDeleteLink = (userDataFormLi) => {

    const removeFormButton = document.createElement('button')
    removeFormButton.classList.add('btn', 'btn-outline-danger', 'fs-5', 'mb-3')

    removeFormButton.innerText = 'Remove user'

    userDataFormLi.append(removeFormButton);

    removeFormButton.addEventListener('click', (e) => {
        e.preventDefault()
        userDataFormLi.remove();
    });
}

document.querySelectorAll('.add_item_link').forEach(btn => btn.addEventListener("click", addFormToCollection))
