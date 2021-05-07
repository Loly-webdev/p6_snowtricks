(function () {
    const containerPicture = document.getElementById('trick_pictures');
    const containerVideo = document.getElementById('trick_videos');

    let indexPicture = containerPicture.querySelectorAll('.edit-trick-content-form-row').length;
    let indexVideo = containerVideo.querySelectorAll('.edit-trick-content-form-row').length;

    if (indexPicture === 0) {
        addPictureForm(containerPicture);
    }
    if (indexVideo === 0) {
        addVideoForm(containerVideo);
    }
    const createModalPicture = function() {
        const btn = '<button type="button" class="js-modal-close">X</button>';
        const formRow = containerPicture.querySelectorAll('.edit-trick-content-form-row');
        const elModal = document.querySelectorAll('.js-modal-picture');
        const modalWrapper = containerPicture.querySelectorAll('.modal-none');

        for (let i = 0; i < formRow.length; i++) {
            formRow[i].classList.add('modal');
            formRow[i].setAttribute("id", "modal-picture-" + i);
            formRow[i].setAttribute("aria-hidden", "true");
            formRow[i].setAttribute("role", "dialog");
            formRow[i].setAttribute("aria-modal", "false");
        }
        for (let i = 0; i < modalWrapper.length; i++) {
            modalWrapper[i].insertAdjacentHTML('afterbegin', btn);
            modalWrapper[i].className = 'modal-wrapper js-modal-stop';
        }
        for (let i = 0; i < elModal.length; i++) {
            elModal[i].setAttribute("href", "#modal-picture-" + i);
        }

    }
    const createModalVideo = function() {
        const btn = '<button type="button" class="js-modal-close">X</button>';
        const formRow = containerVideo.querySelectorAll('.edit-trick-content-form-row');
        const elModal = document.querySelectorAll('.js-modal-video');
        const modalWrapper = containerVideo.querySelectorAll('.modal-none');

        for (let i = 0; i < formRow.length; i++) {
            formRow[i].classList.add('modal');
            formRow[i].setAttribute("id", "modal-video-" + i);
            formRow[i].setAttribute("aria-hidden", "true");
            formRow[i].setAttribute("role", "dialog");
            formRow[i].setAttribute("aria-modal", "false");
        }
        for (let i = 0; i < modalWrapper.length; i++) {
            modalWrapper[i].insertAdjacentHTML('afterbegin', btn);
            modalWrapper[i].className = 'modal-wrapper js-modal-stop';
        }
        for (let i = 0; i < elModal.length; i++) {
            elModal[i].setAttribute("href", "#modal-video-" + i);
        }

    }
    createModalPicture();
    createModalVideo();

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
                this.parentNode.parentNode.remove();
            })
        })
        document.querySelectorAll('button.btn-delete-video.fas.fa-trash-alt').forEach((element) => {
            element.addEventListener('click', function (event) {
                event.preventDefault();
                this.parentNode.parentNode.remove();
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

    let modal = null;
    const openModal = function (event) {
        event.preventDefault()
        let target = document.querySelector(event.target.getAttribute("href"));
        target.querySelector('.fas.fa-trash-alt').style.display = "none";
        target.style.display = "block";
        target.removeAttribute("aria-hidden");
        target.setAttribute("aria-modal", "true");
        modal = target;
        modal.addEventListener('click', closeModal);
        modal.querySelector('.js-modal-close').addEventListener('click', closeModal);
        modal.querySelector('.js-modal-stop').addEventListener('click', stopPropagation);
    }
    const closeModal = function (event) {
        if (modal === null) {
            return;
        }
        event.preventDefault()
        modal.style.display = "none";
        modal.setAttribute("aria-hidden", "true");
        modal.removeAttribute("aria-modal");
        modal.removeEventListener('click', closeModal);
        modal.querySelector('.js-modal-close').removeEventListener('click', closeModal);
        modal.querySelector('.js-modal-stop').removeEventListener('click', stopPropagation);
        modal = null;
    }
    const stopPropagation = function (event) {
        event.stopPropagation();
    }
    document.querySelectorAll('.js-modal-picture').forEach(a => {
        a.addEventListener('click', openModal);
    })
    document.querySelectorAll('.js-modal-video').forEach(a => {
        a.addEventListener('click', openModal);
    })
    const btnDeletePicture = document.querySelectorAll('.btn-delete-picture.fas.fa-trash-alt');
    for (let i = 0; i < btnDeletePicture.length; i++) {
        btnDeletePicture[i].setAttribute("href", "#modal-picture-" + i);
    }
    const btnDeleteVideo = document.querySelectorAll('.btn-delete-video.fas.fa-trash-alt');
    for (let i = 0; i < btnDeleteVideo.length; i++) {
        btnDeleteVideo[i].setAttribute("href", "#modal-video-" + i);
    }

    btnDeleteVideo.forEach((element) => {
        element.addEventListener('click', function (event) {
            let target = document.querySelector(event.target.getAttribute("href"));
            event.preventDefault();
            if(target) {
                target.remove();
            }
            this.parentNode.parentNode.remove();
        })
    })

    btnDeletePicture.forEach((element) => {
        element.addEventListener('click', function (event) {
            let target = document.querySelector(event.target.getAttribute("href"));
            event.preventDefault();
            if(target) {
                target.remove();
            }
            this.parentNode.parentNode.remove();
        })
    })


})()
