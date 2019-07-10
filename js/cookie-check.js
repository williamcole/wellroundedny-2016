/***********************/
/* COOKIE CHECK SCRIPT */
/***********************/

jQuery(document).ready(function($) {

	// check cookie to see if user is visting site for the first time
    var visited = $.cookie('visited');
    
    // check query string
    var vars = [], hash;
    var q = document.URL.split('?')[1];
    if( q != undefined ){
        q = q.split('&');
        for( var i = 0; i < q.length; i++ ) {
            hash = q[i].split('=');
            vars.push(hash[1]);
            vars[hash[0]] = hash[1];
        }
	}
	
	// display newsletter overlay on first visit, or if testing
    if( ( visited == null ) || ( vars['newsletter'] == 'test' ) ) {
		
		// set cookie
		$.cookie( 'visited', 'yes', { expires: 365 } );
		
		// load newsletter colorbox
		$.colorbox({
			inline: true,
			href: '#newsletter-overlay',
			opacity: 0.75,
			close: 'X',
			width: '550px',
			height: '550px'
		});
	
	}

	// set cookie
	$.cookie( 'visited', 'yes', { expires: 365 } );
    
})