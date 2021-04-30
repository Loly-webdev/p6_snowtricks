const btnDeletePicture = document.querySelectorAll('.btn-delete-picture');
for (let i = 0; i < btnDeletePicture.length; i++) {
    btnDeletePicture[i].setAttribute("href", "#modal-picture-" + i);
}
const btnDeleteVideo = document.querySelectorAll('.btn-delete-video');
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
});
