(function () {
    const containerPicture = document.getElementById('trick_pictures');
    const containerVideo = document.getElementById('trick_videos');

    let indexPicture = containerPicture.querySelectorAll('.add-trick-form-row').length;
    let indexVideo = containerVideo.querySelectorAll('.add-trick-form-row').length;

    if (indexPicture === 0) {
        addPictureForm(containerPicture);
    }
    if (indexVideo === 0) {
        addVideoForm(containerVideo);
    }

    document.querySelector('.btn-add-picture').addEventListener('click', function (event) {
        event.preventDefault();
        addPictureForm(containerPicture);
    })

    document.querySelector('.btn-add-video').addEventListener('click', function (event) {
        event.preventDefault();
        addVideoForm(containerVideo);
    })

    function addRemoveBtn() {
        document.querySelectorAll('button.btn-delete-picture.fas.fa-trash-alt').forEach((element) => {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                this.parentNode.remove();
            })
        })
        document.querySelectorAll('button.btn-delete-video.fas.fa-trash-alt').forEach((element) => {
            element.addEventListener('click', function (event) {
                event.preventDefault();
                this.parentNode.remove();
            })
        })
    }

    function addPictureForm(containerPicture) {
        const prototypePicture = containerPicture.getAttribute('data-prototype');
        const templatePicture = prototypePicture.replace(/__name__/g, indexPicture);
        containerPicture.insertAdjacentHTML('beforeend', templatePicture);
        indexPicture++;
        addRemoveBtn();
    }

    function addVideoForm(containerVideo) {
        const prototypeVideo = containerVideo.getAttribute('data-prototype');
        const templateVideo = prototypeVideo.replace(/__name__/g, indexVideo);
        containerVideo.insertAdjacentHTML('beforeend', templateVideo);
        indexVideo++;
        addRemoveBtn();
    }

})()
