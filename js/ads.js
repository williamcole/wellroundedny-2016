/**************/
/* AD SCRIPTS */
/**************/

jQuery(document).ready(function($) {

	// check ad type and show/hide specific fields
	function toggle_ad_fields() {
		
		ad_type = $('#pods-form-ui-pods-meta-ad-type').val();
		
		if( ad_type == 'Image Link' ) {
			
			// IMAGE LINK
			
			// show image field
			$('tr.pods-form-ui-row-name-image').show();

			// show link field
			$('tr.pods-form-ui-row-name-link').show();

			// hide embed code field
			$('tr.pods-form-ui-row-name-embed-code').hide();

		} else if( ad_type == 'Embed Code' ) {
			
			// EMBED CODE
			
			// hide image field
			$('tr.pods-form-ui-row-name-image').hide();

			// hide link field
			$('tr.pods-form-ui-row-name-link').hide();

			// show embed code field
			$('tr.pods-form-ui-row-name-embed-code').show();

		} else {

			// hide everything
			$('tr.pods-form-ui-row-name-image').hide();
			$('tr.pods-form-ui-row-name-link').hide();
			$('tr.pods-form-ui-row-name-embed-code').hide();
		
		}
	}

	// init
	toggle_ad_fields();

	// on type change
	$('#pods-form-ui-pods-meta-ad-type').on('change', toggle_ad_fields );

})