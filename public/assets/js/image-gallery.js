let images = document.querySelectorAll('.image');

images.forEach((image) => {
    image.onclick = () => {

        let imageSource = image.src;
        let imageUrl = imageSource.split('generators.de');
        let newImageUrl = imageUrl[1];

        let container = document.body;
        let imageWindow = document.createElement('div');
        container.appendChild(imageWindow);
        imageWindow.setAttribute('class', 'image-window');
        imageWindow.setAttribute('onclick', 'closeImage()');

        let newImage = document.createElement('img');
        imageWindow.appendChild(newImage);
        newImage.setAttribute('src', newImageUrl);
    }
});

let closeImage = () => {
    document.querySelector('.image-window').remove();
}