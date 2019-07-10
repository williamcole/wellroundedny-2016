<?php

##############
# NEWSLETTER #
##############

// utility function to display html markup for the mailchimp newsletter signup form
function wrny_mailchimp_short_form() {
	?>
	<!-- Begin MailChimp Signup Form -->
	<link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">
	<div id="mc_embed_signup">
		<form action="//wellroundedny.us7.list-manage.com/subscribe/post?u=df8b192ae5d9a5d1ff7f26265&amp;id=5fffe747ff" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
		    <div id="mc_embed_signup_scroll">
				<div class="mc-field-group email">
					<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="SIGN UP WITH YOUR EMAIL">
				</div>
				<div id="mce-responses" class="clear">
					<div class="response" id="mce-error-response" style="display:none"></div>
					<div class="response" id="mce-success-response" style="display:none"></div>
				</div>
				<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
			    <div style="position: absolute; left: -5000px;"><input type="text" name="b_df8b192ae5d9a5d1ff7f26265_5fffe747ff" tabindex="-1" value=""></div>
				<input type="submit" value="&#9658;" name="subscribe" id="mc-embedded-subscribe" class="button">
			</div>
		</form>
	</div>
	<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[4]='FNAME';ftypes[4]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='MMERGE3';ftypes[3]='zip';fnames[1]='MMERGE1';ftypes[1]='date';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
	<!--End mc_embed_signup-->
	<?php
}

/************/

// newsletter overlay
function wrny_get_newsletter_overlay() {
	
	// logo image
	echo '<img class="logo" src="' . get_stylesheet_directory_uri() . '/images/newsletter-logo.png">';
	
	// new mailchimp form
	wrny_mailchimp_form();
		
	/*		
	// old newsletter page
	query_posts( 'page_id=41' );
	if( have_posts() ) {
		while( have_posts() ) : the_post();
			echo the_content();
		endwhile;
	}
	*/	
}

// utility function to display html markup for the mailchimp newsletter signup form
function wrny_mailchimp_form() {
	
	// newsletter page = post_id 41
	$mailchimp = get_post(41); 
	$content = $mailchimp->post_content;
	
	?>
	<!-- Begin MailChimp Signup Form -->
	<link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">
	<div id="mc_embed_signup">
		<form action="//wellroundedny.us7.list-manage.com/subscribe/post?u=df8b192ae5d9a5d1ff7f26265&amp;id=5fffe747ff" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
		    <div id="mc_embed_signup_scroll">
			
				<div class="newsletter-intro"><?php echo $content; ?></div>
								
				<!--<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>-->
				<div class="mc-field-group email">
					<!-- <label for="mce-EMAIL">Email Address  <span class="asterisk">*</span></label> -->
					<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
				</div>
				<div class="mc-field-group half first-name">
					<!-- <label for="mce-FNAME">First Name </label> -->
					<input type="text" value="" name="FNAME" class="" id="mce-FNAME">
				</div>
				<div class="mc-field-group half last-name">
					<!-- <label for="mce-LNAME">Last Name </label> -->
					<input type="text" value="" name="LNAME" class="" id="mce-LNAME">
				</div>
				<div class="mc-field-group half zip-code">
					<!-- <label for="mce-MMERGE3">Zip Code </label> -->
					<input type="text" value="" name="MMERGE3" class="" id="mce-MMERGE3">
				</div>
				<div class="mc-field-group half due-date">
					<div class="datefield">
						<span class="subfield monthfield"><input class="datepart " type="text" pattern="[0-9]*" value="" placeholder="MM" size="2" maxlength="2" name="MMERGE1[month]" id="mce-MMERGE1-month"></span> / 
						<span class="subfield dayfield"><input class="datepart " type="text" pattern="[0-9]*" value="" placeholder="DD" size="2" maxlength="2" name="MMERGE1[day]" id="mce-MMERGE1-day"></span> / 
						<span class="subfield yearfield"><input class="datepart " type="text" pattern="[0-9]*" value="" placeholder="YYYY" size="4" maxlength="4" name="MMERGE1[year]" id="mce-MMERGE1-year"></span>
				        <!-- <span class="small-meta nowrap">( mm / dd / yyyy )</span> -->
					</div>
					<label for="mce-MMERGE1-month">Due Date </label>
				</div>
				<div id="mce-responses" class="clear">
					<div class="response" id="mce-error-response" style="display:none"></div>
					<div class="response" id="mce-success-response" style="display:none"></div>
				</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
			    <div style="position: absolute; left: -5000px;"><input type="text" name="b_df8b192ae5d9a5d1ff7f26265_5fffe747ff" tabindex="-1" value=""></div>
			    <div class="clear">
			    	<input type="submit" value="Join Now" name="subscribe" id="mc-embedded-subscribe" class="button">
			    	<!-- <div style="text-align: center;"><img class="size-full wp-image-373 aligncenter" alt="boxes-4" src="http://wellroundedny.com/wp-content/uploads/2013/02/boxes-4.png" width="86" height="26" /></div> -->
				</div>
			</div>
		</form>
	</div>
	<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[4]='FNAME';ftypes[4]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='MMERGE3';ftypes[3]='zip';fnames[1]='MMERGE1';ftypes[1]='date';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
	<!--End mc_embed_signup-->

	<?php
}