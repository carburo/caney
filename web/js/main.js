jQuery(function($) {

	//#main-slider
	$(function(){
		$('#main-slider.carousel').carousel({
			interval: 8000
		});
	});

	$( '.centered' ).each(function( e ) {
		$(this).css('margin-top',  ($('#main-slider').height() - $(this).height())/2);
	});

	$(window).resize(function(){
		$( '.centered' ).each(function( e ) {
			$(this).css('margin-top',  ($('#main-slider').height() - $(this).height())/2);
		});
	});

	//portfolio
	$(window).load(function(){
		$portfolio_selectors = $('.portfolio-filter >li>a');
		if($portfolio_selectors!='undefined'){
			$portfolio = $('.portfolio-items');
			// $portfolio.isotope({
			// 	itemSelector : 'li',
			// 	layoutMode : 'fitRows'
			// });
			$portfolio_selectors.on('click', function(){
				$portfolio_selectors.removeClass('active');
				$(this).addClass('active');
				var selector = $(this).attr('data-filter');
				// $portfolio.isotope({ filter: selector });
				return false;
			});
		}
	});

	//contact form
	var form = $('.contact-form');
	form.submit(function () {
		$this = $(this);
		$.post($(this).attr('action'), $(this).serialize(), function(data) {
			$this.prev().text(data.message).fadeIn().delay(3000).fadeOut();
            $this.fadeOut().delay(3000).fadeIn();
            $this[0].reset();
		},'json');
		return false;
	});

    //booking form
    var form = $('.booking-form');
    form.submit(function () {
        var $this = $(this);
        $.post($(this).attr('action'), $(this).serialize(), function(data) {
            $('#success-message').html(data.message);
            $('#success-div').fadeIn();
            $this.fadeOut();
            //$this[0].reset();
        },'json');
        return false;
    });

	//goto top
	$('.gototop').click(function(event) {
		event.preventDefault();
		$('html, body').animate({
			scrollTop: $("body").offset().top
		}, 500);
	});

    $('.swipe-gallery').each( function() {
        // Get the items.
        var $pic = $(this),
            getItems = function() {
                var items = [];
                $pic.find('a').each(function() {
                    var $href = $(this).attr('href'),
                        $size   = $(this).data('size').split('x'),
                        $width  = $size[0],
                        $height = $size[1];

                    var item = {
                        src : $href,
                        w   : $width,
                        h   : $height
                    }

                    items.push(item);
                });
                return items;
            }

        var items = getItems();

        // Preload image.
        var image = [];
        $.each(items, function(index, value) {
            image[index]     = new Image();
            image[index].src = value['src'];
        });

        // Binding click event.
        var $pswp = $('.pswp')[0];
        $pic.on('click', 'figure', function(event) {
            event.preventDefault();

            var $index = $(this).data('order');
            var options = {
                index: $index,
                bgOpacity: 1,
                showHideOpacity: true
            }

            var lightBox = new PhotoSwipe($pswp, PhotoSwipeUI_Default, items, options);
            lightBox.init();
        });
    });
});

function translateInfoNights(locale, nights) {
    var text;
    switch (locale) {
        case "es":
            switch (nights) {
                case 0: text = "Elija un rango de fechas para la reserva."; break;
                case 1: text = "Reserva por una noche."; break;
                default: text = "Reserva por " + nights + " noches.";
            }
        case "fr":
            switch (nights) {
                case 0: text = "Elija un rango de fechas para la reserva."; break;
                case 1: text = "Reserva por una noche."; break;
                default: text = "Reserva por " + nights + " noches.";
            }
        case "de":
            switch (nights) {
                case 0: text = "Elija un rango de fechas para la reserva."; break;
                case 1: text = "Reserva por una noche."; break;
                default: text = "Reserva por " + nights + " noches.";
            }
        default:
            switch (nights) {
                case 0: text = "Choose a date range for the reservation."; break;
                case 1: text = "Reservation for one night."; break;
                default: text = "Reservation for " + nights + " nights.";
            }
    }
    return text;   
}