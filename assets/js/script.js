
( function( $ ) {
	
	$(function(){
		$('#homeslider').bxSlider({
			wrapperClass: 'homeslider-wrapper',
			auto: !true,
			controls: !false,
			slideWidth: 1300,
		});
		
		$('.fancybox,.fancy-img').fancybox();
		
		$('#site-partenaires ul').bxSlider({
			wrapperClass: 'site-partenaires-wrapper',
			auto: true,
			pause: 10000,
			controls: false,
			pager: false,
			minSlides: 1,
			maxSlides: 5,
			slideWidth: 140,
			slideMargin: 5,
		});
		
		$('#site-services ul').bxSlider({
			wrapperClass: 'site-services-wrapper',
			auto: !true,
			pause: 10000,
			controls: !false,
			hideControlOnEnd: !false,
			infiniteLoop: false,
			pager: false,
			minSlides: 1,
			maxSlides: 4,
			slideWidth: 260,
			slideMargin: 15,
		});
		
		$('.navbar-toggle').on('click', function(){
			$($(this).attr('data-target')).parent().toggleClass('menu-toggle-off');
		})
	});
	
	
	$(document).ready(function() {
		initfb(document, 'script', 'facebook-jssdk');
	});
	
} )( jQuery );

	
	function initfb(d, s, id)
	{
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) 
			return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=334341610034299";
		fjs.parentNode.insertBefore(js, fjs);
	}






