/**
 * Created by david.cannon on 3/31/16.
 */
$(document).ready(function() {
    var target = $('.show-more-link');

    target.on('click', function(e) {
        e.preventDefault();

        var text = $(this).find('.text');

        if(text.text() == 'Show More') {
            $(this).parent().find('.res-details ul li').css('display', 'block');
            $('a', this).html('<span class="text">Show Less</span> <i class="fa fa-chevron-up"></i>');
        }
        else {
            $(this).parent().find('.res-details ul li').css('display', 'none');
            $(this).parent().find('.res-details ul:nth-child(1) li:nth-child(1), .res-details ul:nth-child(1) li:nth-child(2)').css('display', 'block');
            $('a', this).html('<span class="text">Show More</span> <i class="fa fa-chevron-down"></i>');
        }
    });

    var count = 10;
    var schumerCount = $('.schumer-package').length;

    if(count < schumerCount) {
        $('.show-more-results').css('display', 'block');
    }

    $('.show-more-results').on('click', function(e) {
        e.preventDefault();

        count = count + 10;

        $('.schumer-package:nth-child(-n+'+count+')').css('display', 'block');

        if(count >= schumerCount) {
            $('.show-more-results').css('display', 'none');
        }
    });

    // defining this here so there is not a lookup on every scroll
    var beginScrollTopHeight = 0;
    if ( $('.res-schumer-box').length > 2) {
        beginScrollTopHeight = $( $('.res-schumer-box')[1] ).offset().top + $( $('.res-schumer-box')[1] ).height();
    }

    $(window).scroll(function () {
        if ($(window).scrollTop() <= beginScrollTopHeight) {
            $('.back-to-top').css({'display': 'none'});
        }
        else {
            $('.back-to-top').css({'display': 'block'});
        }
    });
});