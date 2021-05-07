const $ = require('jquery');
$(document).ready(function () {
    $(document).on('click', '.btn-delete-picture', function () {
        let classes = $(this).attr('class');
        console.log(classes);
        let href = $(this).attr('href');
        console.log(href);
        let data = $(this).data('id');
        console.log(data);
    })
});
