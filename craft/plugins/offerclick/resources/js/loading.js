/**
 * Created by david.cannon on 4/30/16.
 */
$(document).ready(function() {

    $('#offer-click').on('click', function(e) {
        e.preventDefault();
        alert($(this).attr('href').val());
    });
});