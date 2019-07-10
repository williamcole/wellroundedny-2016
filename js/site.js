/* Site JS
-------------------------------------------------------------- */

jQuery(document).ready(function($) {
	
	/**********/
	/* HEADER */
	/**********/
	
	// dynamically set gallery height
	resize_nav_boxes();
	
	// adjust gallery height on window resize
    $(window).resize(function(){    	
    	resize_nav_boxes();
    });
    
    function resize_nav_boxes() {
    	nav_box_width = $('.nav-boxes li:first a').width();
    	//console.log('nav_box_width = ' + nav_box_width);
		$('.nav-boxes li a').height( nav_box_width );
	}
	
	// nav toggle
	$('.toggle-nav').click(function() {
		$('#site-nav-box').toggle();
		$('#site-search-box').hide();
		//$('.nav-menu').animate({width:'toggle'},350);
	});
	
	$('#site-nav-box .close').click(function() {
		$('#site-nav-box').hide();
		$('#site-search-box').hide();
	});
	
	// search toggle
	$('.toggle-search').click(function() {
		$('#site-nav-box').hide();
		$('#site-search-box').toggle();
		//$('#site-search-box').animate({width:'toggle'},350);
	});
	
	$('#site-search-box .close').click(function() {
		$('#site-nav-box').hide();
		$('#site-search-box').hide();

	});
	
	/*******************************/
	
	// helper text for newsletter email input
    newsletter_email = $('#footer-newsletter input[type="email"]');
	newsletter_help = 'SIGN UP WITH YOUR EMAIL';
	
	newsletter_email.focus(function() {
    	if ($(this).val() == newsletter_help) {
    		$(this).removeClass("helper-text");
    		$(this).val("");
    	}
    });
    
    newsletter_email.blur(function() {
        if ($(this).val() == "") {
        	$(this).addClass("helper-text");
        	$(this).val(newsletter_help);
        }
    });
    
    newsletter_email.blur();
	
	
	/**********/
	/* FOOTER */
	/**********/
	
	// open footer social media links in new window
	$('#footer-nav').find("a:contains('Facebook')").attr('target','_blank');
	$('#footer-nav').find("a:contains('Twitter')").attr('target','_blank');
	$('#footer-nav').find("a:contains('Instagram')").attr('target','_blank');
	$('#footer-nav').find("a:contains('Pinterest')").attr('target','_blank');
	
});