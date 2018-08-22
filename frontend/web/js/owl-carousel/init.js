var owl = $('.owl-carousel');
owl.owlCarousel({
	items: 6,
	margin: 25,
	loop: true,
	nav: false,
	dots: false,
	autoplay: true,
	responsive : {
		0 : {
			items: 1,
		},
		350 : {
			items: 2,
		},
		550 : {
			items: 3,
		},
		768 : {
			items: 4,
		},
		992 : {
			items: 6,
		}
	}
});
	// Go to the next item
	$('.partners_gallery .arr_right').click(function() {
		owl.trigger('next.owl.carousel');
	})
	// Go to the previous item
	$('.partners_gallery .arr_left').click(function() {
	    // With optional speed parameter
	    // Parameters has to be in square bracket '[]'
	    owl.trigger('prev.owl.carousel', [300]);
	})

