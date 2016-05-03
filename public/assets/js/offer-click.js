/**
 * Created by david.cannon on 4/30/16.
 */
$(document).ready(function() {

    $('.offer-click').on('click', function(e) {
        e.preventDefault();

        var offerUrl = $(this).attr('href');

        $('#loading-modal').modal('show');

        window.setTimeout(function() {
                processClick(offerUrl)
            }, 5000
        );

    });

    var processClick = function(offerUrl) {

        $.get( "/offer-click", {offerUrl: offerUrl}, function() {
            })
            .done(function() {
            })
            .fail(function() {
            });

        $('#loading-modal').modal('hide');

    }
});