/* Admin Toggle Custom Fields for Posts
-------------------------------------------------------------- */

jQuery(document).ready(function($) {
	
	// checkbox objects
	$giveaways_box = $('#categorychecklist').find("label:contains('Giveaways')").children('input:checkbox');
	
	// init
	toggle_giveaways_fields();
	
	// toogle custom field display
	$giveaways_box.click(function() {
		toggle_giveaways_fields();
	});	
	
	function toggle_giveaways_fields() {
		if( $giveaways_box.is(':checked') ) {
			$('#pods-meta-more-fields').find("label:contains('Giveaway Winner')").parent('th').parent('tr').show();
		} else {
			$('#pods-meta-more-fields').find("label:contains('Giveaway Winner')").parent('th').parent('tr').hide();
		}		
	}
	
});