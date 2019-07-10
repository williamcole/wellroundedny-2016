<?php

#######
# ADS #
#######

function wrny_ad_script() {
    global $post_type;
    if( 'ad' == $post_type ) {
    	wp_enqueue_script( 'ads', get_stylesheet_directory_uri() . '/js/ads.js', array( 'jquery' ), null, true );
    }
}
add_action( 'admin_print_scripts-post-new.php', 'wrny_ad_script', 11 );
add_action( 'admin_print_scripts-post.php', 'wrny_ad_script', 11 );

function wrny_ads() {

	$todays_date = date('Y-m-d');
	
	$ads = new WP_Query( array(
		'post_type' => 'ad',
		'post_status' => 'publish',
		'order' => 'ASC',
		'orderby' => 'rand',
		'posts_per_page' => 1,
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => 'start_date',
				'value' => $todays_date,
				'compare' => '<=',
				'type' => 'DATE',
			),
			array(
				'key' => 'end_date',
				'value' => $todays_date,
				'compare' => '>=',
				'type' => 'DATE'
			),
			array(
				'key' => 'inactive',
				'value' => 1,
				'compare' => '!=',
			),
		),	
	) );
	
	if( $ads->have_posts() ) :
		while( $ads->have_posts() ) : $ads->the_post();
			echo wrny_ad_markup( get_the_ID() );
		endwhile;
	endif;

	wp_reset_query();

}

function wrny_ad_markup( $id ) {

	// define some vars
	global $post, $ad_id;
	$ad_id = ( !empty( $id ) ) ? $id : get_the_ID();
	$ad_type = get_post_meta( $ad_id, 'ad_type', true );
	$ad_class = strtolower( str_replace( ' ', '', $ad_type ) );
	$ad_views = intval( get_post_meta( $ad_id, 'views', true ) );
	$ad_views_new = $ad_views + 1;
	$ad_html = '';
	
	# TODO: FIX THIS
	// increment number of views
	update_post_meta( $ad_id, 'views', $ad_views_new, $ad_views );

	switch( $ad_type ) {
		
		case 'Image Link' :
			$ad_img = get_post_meta( $ad_id, 'image', false );
			if( !empty( $ad_img ) ) {
				$ad_img_id = $ad_img[0]['ID'];
				$ad_img_html = wp_get_attachment_image( $ad_img_id, 'ad' );
			}
			$ad_link = get_post_meta( $ad_id, 'link', true );
			if( !empty( $ad_img_html ) && !empty( $ad_link ) ) {
				$ad_html .= '<div id="ad" class="' . $ad_class . '">';
				$ad_html .= '<a href="' . $ad_link . '" target="_blank">' . $ad_img_html . '</a>';
				$ad_html .= '</div>';
			}
		break;

		case 'Embed Code' :
			$ad_embed_code = get_post_meta( $ad_id, 'embed_code', true );
			if( !empty( $ad_embed_code ) ) {
				$ad_html .= '<div id="ad" class="' . $ad_class . '">';
				# TODO: sanitize ???
				$ad_html .= $ad_embed_code;
				$ad_html .= '</div>';
			}
		break;
	}
	
	return $ad_html;
}