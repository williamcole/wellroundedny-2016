/******************/
/* PINTEREST HACK */
/******************/

jQuery(document).ready(function($) {

	/*
	
	// get content width
	pinit_w = $('.entry-content').width();
	console.log(pinit_w);
	
	$('img.pinit.entry-vertical-image').each(function(){
		
		console.log($(this));
		
		console.log('pinit');
		$pinit_btn = $(this).parent('span').children('.xc_pin');
		$pinit_btn.css('right', '-'+pinit_w+'px');
		$pinit_btn.css('top','0');
		$pinit_btn.on('hover', function() {
			$(this).css('display','block');
		});
	
	});
	*/

	/*
	$('.entry-content img').each(function(){

		// TODO: make sure image is not in a gallery
		
		var pinit_url = encodeURIComponent( $(document).find('link[rel="canonical"]').attr('href') ),
			pinit_img = encodeURIComponent( $(this).attr('src') ),
			pinit_desc = encodeURIComponent( $(document).find('title').text() );

		// wrap images in a div and add pinit link
		$(this).wrap('<div class="pinit-wrap">').after('<a href="http://www.pinterest.com/pin/create/button/?url='+pinit_url+'&media='+pinit_img+'&description='+pinit_desc+'" class="pinit-button" data-pin-do="buttonPin">Pin It</a>');

		// toggle class on hover
		$('.pinit-wrap').hover(
			function(){ $(this).addClass('hover'); },
			function(){ $(this).removeClass('hover'); }
		);

		// TODO: style the button

	});

	*/
});