const closeButtons = document.querySelectorAll('.close-button-js');
const modalWindow = document.querySelector('#modalWindow');

closeButtons.forEach(closeButton =>closeButton.addEventListener('click', (e) => {
    e.preventDefault();
    modalWindow.style.display = 'none';
}));

function copyData(htmlElement)
{
    navigator.clipboard.writeText(htmlElement.innerText)
        .then(() => {
            window.alert("copied!");
        })
}

function saveData(htmlElement)
{
    if(!htmlElement)
    {
        return;
    }

    let blob = new Blob([htmlElement.innerText], {type: "text/plain"});
    let url = window.URL.createObjectURL(blob);
    let link = document.createElement("a");
    link.href = url;

    if(htmlElement.parentElement.getAttribute("id") === null) {
        link.download = htmlElement.getAttribute("id");
    } else {
        link.download = htmlElement.parentElement.getAttribute("id");
    }

    if(!confirm("save?"))
    {
        return;
    }

    link.click();
    window.URL.revokeObjectURL(url);
    link.remove();
}


