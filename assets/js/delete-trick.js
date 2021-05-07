//suppression mini-image
// on récupère ttes les classes correspondantes aux boutons de suppression des images
const btnDeletePicture = document.querySelectorAll('.btn-delete-picture.fas.fa-trash-alt');
for (let i = 0; i < btnDeletePicture.length; i++) {// on boucle dessus...
    btnDeletePicture[i].setAttribute("href", "#modal-picture-" + i);//pour recupérer la modal de chq image
}

btnDeletePicture.forEach((element) => {// on boucle sur chaque element pour écouter le click
    element.addEventListener('click', function (e) {
        let target = document.querySelector(e.target.getAttribute("href"));// on récupère le href cliqué (modal)
        e.preventDefault();//on stop la navigation par défaut
        if (confirm("Voulez vous vraiment supprimer cette image ?")) {//confirmation utilisateur
            target.remove();//on supp la modale
            this.parentNode.parentNode.remove();//on supp les neuds parends (image et boutons)
        } else {
            this.location;//si on annule, on reste sur la page
        }
    })
})

//suppression mini-videos
const btnDeleteVideo = document.querySelectorAll('.btn-delete-video.fas.fa-trash-alt');
for (let i = 0; i < btnDeleteVideo.length; i++) {
    btnDeleteVideo[i].setAttribute("href", "#modal-video-" + i);
}

btnDeleteVideo.forEach((element) => {
    element.addEventListener('click', function (e) {
        let target = document.querySelector(e.target.getAttribute("href"));
        e.preventDefault();
        if (confirm("Do you realy want to delete this video ?!!")) {
            target.remove();
            this.parentNode.parentNode.remove();
        } else {
            this.location;
        }
    })
})


/*const $ = require('jquery');
$(document).ready(function () {
    $(document).on('click', '.btn-delete-picture', function () {
        let classes = $(this).attr('class');
        console.log(classes);
        let href = $(this).attr('href');
        console.log(href);
        let data = $(this).data('id');
        console.log(data);
    })
});*/

/*window.onload = () => {
    // Gestion des boutons "Supprimer"
    let links = document.querySelectorAll("[btn-delete-picture]")

    // On boucle sur links
    for(link of links){
        // On écoute le clic
        link.addEventListener("click", function(e){
            // On empêche la navigation
            e.preventDefault()

            // On demande confirmation
            if(confirm("Voulez-vous supprimer cette image ?")){
                // On envoie une requête Ajax vers le href du lien avec la méthode DELETE
                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({"_token": this.dataset.token})
                }).then(
                    // On récupère la réponse en JSON
                    response => response.json()
                ).then(data => {
                    if(data.success)
                        this.parentElement.remove()
                    else
                        alert(data.error)
                }).catch(e => alert(e))
            }
        })
    }
}*/
