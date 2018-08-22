$(document).ready(function() {

	$('header .main_menu a.more_mnu').on("click", function(){
		if ($('header .main_menu .popup_menu').css('display') == 'none')
		{
			$('header .main_menu .popup_menu').fadeIn(500);
			$('header .main_menu a.more_mnu').css('color', '#ca1923');
		}
		else
		{
			$('header .main_menu .popup_menu').fadeOut(500);
			$('header .main_menu a.more_mnu').css('color', '');
		}
	});


	$('header .main_menu .mob i.fa-bars').on("click", function(){
		$('.over_menu').removeClass('animated bounceOutLeft');
		$('.over_menu').css('display','block');
		$('.over_menu').addClass('animated bounceInLeft');
	});
	$('.over_menu .cl').on("click", function(){
		$('.over_menu').removeClass('animated bounceInLeft');
		$('.over_menu').addClass('animated bounceOutLeft');
	});
	
	$('.over_menu .main_menu_tog.main').on("click", function(){
		if ($('.over_menu .main_menu_main').css('display') == 'none')
		{
			$('.over_menu .main_menu_main').fadeIn(500);
		}
		else
		{
			$('.over_menu .main_menu_main').fadeOut(500);
		}
	});
	
	$('.over_menu .main_menu_tog.my').on("click", function(){
		if ($('.over_menu .main_menu_my').css('display') == 'none')
		{
			$('.over_menu .main_menu_my').fadeIn(500);
		}
		else
		{
			$('.over_menu .main_menu_my').fadeOut(500);
		}
	});

	$('.top_menu .bars').on("click", function(){
		$('.over_menu').removeClass('animated bounceOutLeft');
		$('.over_menu').css('display','block');
		$('.over_menu').addClass('animated bounceInLeft');
	});

	$('.top_menu .up_arr').on("click", function(){
		$('body,html').animate({scrollTop:0},800);
	});

	$('section article#how_order .switchers .all').on("click", function(){
		$('section article#how_order .partners_gallery').fadeOut(1);
		$('section article#how_order .partners').fadeIn(500);
	});

	$('section article#how_order .switchers .gallery').on("click", function(){
		$('section article#how_order .partners').fadeOut(1);
		$('section article#how_order .partners_gallery').fadeIn(500);
	});


        $('.call_me').click(function(){
            $('#recall_me .err').css('display', 'none');
            $('#recall_me .err').css('margin-bottom', '30px');
            $('#recall_me a.subm').css('display', 'inline');
            $('#recall_me input').val('');
        });
                    
                    

	$('.call_me').magnificPopup({
            type: 'inline',

            fixedContentPos: true,
            fixedBgPos: true,

            overflowY: 'auto',

            closeBtnInside: true,
            preloader: true,
            
            callbacks: {open: function() {$('.navbar-fixed-top').css('overflow-y', 'scroll');},close: function() {$('.navbar-fixed-top').css('overflow-y', 'hidden');}},

            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in'
        });

});

$(window).scroll(function() {

	if($(this).scrollTop() > 800) {
		$('.top_menu').fadeIn(); 
	}
	else
	{
		$('.top_menu').fadeOut();
	}
});

$('header .search input').css('padding-right', parseInt($('header .search button').outerHeight()) + 75 + 'px' );

