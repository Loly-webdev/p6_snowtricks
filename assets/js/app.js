/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (base.css in this case)
import '../styles/app.scss';

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

$(function() {
    // Multiple images preview in browser
    const imagesPreview = function (input, placeToInsertImagePreview) {

        if (input.files) {
            const filesAmount = input.files.length;

            for (let i = 0; i < filesAmount; i++) {
                const reader = new FileReader();

                reader.onload = function (event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#trick_pictures').on('change', function() {
        imagesPreview(this, '#preview');
    });
});
