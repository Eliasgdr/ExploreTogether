function redirectMessages() {
    window.location.replace('./chat.php');
}

document.addEventListener('DOMContentLoaded', () => {
    const audioElement = document.getElementById('hoverAudio');
    audioElement.currentTime = 15;

    // Utilisation de la délégation d'événements avec mouseover et mouseout
    document.addEventListener('mouseover', function(event) {
        // Vérifier si l'élément survolé a la classe 'imageProfile'
        if (event.target.classList.contains('imageProfile')) {
            audioElement.play().catch(error => {
                console.log('Playback prevented:', error);
            });
        }
    });

    document.addEventListener('mouseout', function(event) {
        // Vérifier si l'élément quitte a la classe 'imageProfile'
        if (event.target.classList.contains('imageProfile')) {
            audioElement.pause();
            audioElement.currentTime = 15;
        }
    });
});


document.addEventListener('DOMContentLoaded', (event) => {
    const selectImage = document.querySelector('.select-image');
    const inputFile = document.querySelector('#file');
    const imgArea = document.querySelector('.img-area');

    selectImage.addEventListener('click', function () {
        inputFile.click();
    });

    inputFile.addEventListener('change', function () {
        const image = this.files[0];
        if (image && image.size < 2000000) {
            const reader = new FileReader();
            reader.onload = () => {
                const allImg = imgArea.querySelectorAll('img');
                allImg.forEach(item => item.remove());
                const imgUrl = reader.result;
                const img = document.createElement('img');
                img.src = imgUrl;
                imgArea.appendChild(img);
                imgArea.classList.add('active');
                imgArea.dataset.img = image.name;
            };
            reader.readAsDataURL(image);
        } else {
            alert("Image size more than 2MB");
        }
    });
});