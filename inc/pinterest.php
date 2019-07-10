<?php

#############
# PINTEREST #
#############

function wrny_pinterest_scripts() {
    if( is_single() ) {
    	//wp_enqueue_script( 'pinterest', '//assets.pinterest.com/js/pinit.js', array( 'jquery' ), null, true );
    	//wp_enqueue_script( 'pinterest-custom', get_stylesheet_directory_uri() . '/js/pinterest.js', array( 'jquery' ), null, true );
    }
}
//add_action( 'wp_enqueue_scripts', 'wrny_pinterest_scripts', 11 );
