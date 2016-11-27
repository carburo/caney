$(document).ready(function() {
	// Material
	$.material.init();

	// Preloader
	$(window).load(function() {
	  "use strict";
	  $('#loader').fadeOut();
	});


	//WOW Scroll Spy
	var wow = new WOW({
	    //disabled for mobile
	    mobile: false
	});
	wow.init();
	
	// MixitUp Init
	$('#mea-portfolio').mixItUp(); 
	

 	// Bootstrap Carousel
	$('#main-slide').carousel({
		interval: 15000,
	});

	// Testimonial Carousel
	  $("#testimonial-carousel").owlCarousel({
	      slideSpeed : 300,
	      paginationSpeed : 400,
	      singleItem: true,
	      autoPlay: 3000,
	      stopOnHover : true,
	 
	  });

	  // Flickr Carousel
	  $("#flickr-carousel").owlCarousel({
	      slideSpeed : 300,
	      paginationSpeed : 400,
	      items : 1,
	      autoPlay: 3000,
	      stopOnHover : true,
	 
	  });

	  // Image Carousel
	  $("#mea-image-carousel").owlCarousel({
	      slideSpeed : 300,
	      paginationSpeed : 400,
	      items : 4,
	      autoPlay: 3000,
	      stopOnHover : true,
	  });

	  // Image Carousel
	  $("#team-carousel").owlCarousel({
	      slideSpeed : 300,
	      paginationSpeed : 400,
	      items : 4,
	      autoPlay: 3000,
	      stopOnHover : true,
	  });

	  // Counter JS
    $('.work-counter-section').on('inview', function(event, visible, visiblePartX, visiblePartY) {
        if (visible) {
            $(this).find('.timer').each(function() {
                var $this = $(this);
                $({
                    Counter: 0
                }).animate({
                    Counter: $this.text()
                }, {
                    duration: 3000,
                    easing: 'swing',
                    step: function() {
                        $this.text(Math.ceil(this.Counter));
                    }
                });
            });
            $(this).off('inview');
        }
    });

	  // OkayNav
	  var navigation = $('#nav-main').okayNav();

	  // Back Top Link
	  var offset = 200;
	  var duration = 500;
	  $(window).scroll(function() {
	    if ($(this).scrollTop() > offset) {
	      $('.back-to-top').fadeIn(400);
	    } else {
	      $('.back-to-top').fadeOut(400);
	    }
	  });
	  $('.back-to-top').click(function(event) {
	    event.preventDefault();
	    $('html, body').animate({
	      scrollTop: 0
	    }, 600);
	    return false;
	  });

    //booking form
    var form = $('.booking-form');
    form.submit(function () {
		$('#loader').fadeIn();
        var $this = $(this);
        $.post($(this).attr('action'), $(this).serialize(), function(data) {
			$('#loader').fadeOut();
            $('#success-message').html(data.message);
            $('#success-section').fadeIn();
            $this.fadeOut();
            //$this[0].reset();
        },'json');
        return false;
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
				case 0: text = "Choisissez une rangée de date pour fair la réservation."; break;
				case 1: text = "Réservation pour une nuit."; break;
				default: text = "Réservation pour " + nights + " nuits.";
			}
		case "de":
			switch (nights) {
                case 0: text = "Choose a date range for the reservation."; break;
                case 1: text = "Reservation for one night."; break;
                default: text = "Reservation for " + nights + " nights.";
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