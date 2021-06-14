const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

$(document).ready(function () {

    // Recovery of the <div>
    let $containerPicture = $('div#trick_pictures');

    // Définition of the counter to name the added fiels
    let index = $containerPicture.find('input').length;

    // Need a new field to each click on the add link
    $('#add_picture').click(function (e) {
        addPicture($containerPicture);
        e.preventDefault();
        return false;
    });

    // Adding a first fiels if there is not already one
    if (index === 0) {
        addPicture($containerPicture);
    } else {
        // Adding a delete link
        $containerPicture.children('div').each(function () {
            addDeleteLink($(this));
        });
    }

    // To Add a PictureType form
    function addPicture($containerPicture) {
        const template = $containerPicture.attr('data-prototype').replace(/__name__/g, index)
        ;

        // Creation of an jQuery object which contains the template
        let $prototype = $(template);

        addDeleteLinkPicture($prototype);

        // Addition of the prototype at the end of the <div>
        $containerPicture.append($prototype);

        // Counter increment
        index++;
    }

    // To add a delete link
    function addDeleteLinkPicture($prototype) {
        // Link creation
        let $deleteLinkPicture = $('<button type="button" class="btn-delete-picture">X</button>');

        // Added link
        $prototype.append($deleteLinkPicture);

        $deleteLinkPicture.click(function (e) {
            $prototype.remove();
            e.preventDefault();
            return false;
        });
    }

    // Recovery of the <div>
    let $containerVideo = $('div#trick_videos');

    // Definition of the counter to name the added files
    index = $containerVideo.find('input').length;

    // Need a new field to each click on the add link
    $('#add_video').click(function (e) {
        addVideo($containerVideo);
        e.preventDefault();
        return false;
    });

    // Adding a first files if there is not already one
    if (index === 0) {
        addVideo($containerVideo);
    } else {
        // Adding a delete link
        $containerVideo.children('div').each(function () {
            addDeleteLink($(this));
        });
    }

    // To Add a VideoType form
    function addVideo($containerVideo) {
        const template = $containerVideo.attr('data-prototype').replace(/__name__/g, index)
        ;

        // Creation of an jQuery object which contains the template
        let $prototype = $(template);

        addDeleteLinkVideo($prototype);

        // Addition of the prototype at the end of the <div>
        $containerVideo.append($prototype);

        // Counter increment
        index++;
    }

    // To add a delete link
    function addDeleteLinkVideo($prototype) {
        // Link creation
        let $deleteLinkVideo = $('<button type="button" class="btn-delete-video">X</button>');

        // Added link
        $prototype.append($deleteLinkVideo);

        $deleteLinkVideo.click(function (e) {
            $prototype.remove();

            e.preventDefault();
            return false;
        });
    }
});
