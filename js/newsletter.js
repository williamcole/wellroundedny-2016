/**********************/
/* NEWSLETTER SCRIPTS */
/**********************/

jQuery(document).ready(function($) {
	
	/*
	
	// change value of submit button
	$('.pushbutton-wide').val('JOIN NOW');
	
	// modify thank you text
	$('.entry-content blockquote').hide();
	//$('.entry-content h3').html('Thanks for signing up!');
	
	$('#newsletter-content blockquote').hide();	
	$('#newsletter-content h3').html('Thanks for signing up!');
	
	// helper text for name input			
	input_name = $("form.contact-form input[name*='name']");
    
	input_name.focus(function(srcc) {
    	if ($(this).val() == 'Name') {
    		$(this).removeClass("helper-text");
    		$(this).val("");
    	}
    });
    
    input_name.blur(function() {
        if ($(this).val() == "") {
        	$(this).addClass("helper-text");
        	$(this).val('Name');
        }
    });
    
    input_name.blur();
    
    // helper text for email input
    input_email = $('form.contact-form input[type="email"]');
	
	input_email.focus(function(srcc) {
    	if ($(this).val() == "Email") {
    		$(this).removeClass("helper-text");
    		$(this).val("");
    	}
    });
    
    input_email.blur(function() {
        if ($(this).val() == "") {
        	$(this).addClass("helper-text");
        	$(this).val("Email");
        }
    });
    
    input_email.blur();

    // zip code
    input_zipcode = $("form.contact-form input[name*='zipcode']");
    
    input_zipcode.focus(function(srcc) {
        if ($(this).val() == 'Zip Code') {
            $(this).removeClass("helper-text");
            $(this).val("");
        }
    });
    
    input_zipcode.blur(function() {
        if ($(this).val() == "") {
            $(this).addClass("helper-text");
            $(this).val('Zip Code');
        }
    });
    
    input_zipcode.blur();

    // due date
    input_duedate = $("form.contact-form input[name*='duedate']");
    
    input_duedate.focus(function(srcc) {
        if ($(this).val() == 'Due Date') {
            $(this).removeClass("helper-text");
            $(this).val("");
        }
    });
    
    input_duedate.blur(function() {
        if ($(this).val() == "") {
            $(this).addClass("helper-text");
            $(this).val('Due Date');
        }
    });
    
    input_duedate.blur();

	*/



    /* Mailchimp */
	
	/*
	
    // email
    input_em = $('.mc-field-group.email input');
    input_em_txt = 'SIGN UP WITH YOUR EMAIL';
    input_em.focus(function() {
        if ($(this).val() == input_em_txt) {
            $(this).removeClass("helper-text");
            $(this).val("");
        }
    });
    input_em.blur(function() {
        if ($(this).val() == "") {
            $(this).addClass("helper-text");
            $(this).val(input_em_txt);
        }
    });
    input_em.blur();
	
    // first name
    input_fn = $('.mc-field-group.first-name input');
    input_fn_txt = 'First Name';
    input_fn.focus(function() {
        if ($(this).val() == input_fn_txt) {
            $(this).removeClass("helper-text");
            $(this).val("");
        }
    });
    input_fn.blur(function() {
        if ($(this).val() == "") {
            $(this).addClass("helper-text");
            $(this).val(input_fn_txt);
        }
    });
    input_fn.blur();

    // last name
    input_ln = $('.mc-field-group.last-name input');
    input_ln_txt = 'Last Name';
    input_ln.focus(function() {
        if ($(this).val() == input_ln_txt) {
            $(this).removeClass("helper-text");
            $(this).val("");
        }
    });
    input_ln.blur(function() {
        if ($(this).val() == "") {
            $(this).addClass("helper-text");
            $(this).val(input_ln_txt);
        }
    });
    input_ln.blur();

    // zip code
    input_zc = $('.mc-field-group.zip-code input');
    input_zc_txt = 'Zip Code';
    input_zc.focus(function() {
        if ($(this).val() == input_zc_txt) {
            $(this).removeClass("helper-text");
            $(this).val("");
        }
    });
    input_zc.blur(function() {
        if ($(this).val() == "") {
            $(this).addClass("helper-text");
            $(this).val(input_zc_txt);
        }
    });
    input_zc.blur();

	$('#mc-embedded-subscribe-form').on('submit', function() {
	    // validate required email field
        email = $('input#mce-EMAIL').val();
        if( isValidEmailAddress( email ) ) {
            console.log(email + ' is a valid email address');
            // hide form and display success message
            $('#mc_embed_signup input').fadeOut();
            $('#mc_embed_signup .mc-field-group').fadeOut();
        }
    });
    
    */
	
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    };

    		    
});