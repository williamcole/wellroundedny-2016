<?php

########
# SHOP #
########

// config
define( 'SHOP_MAX_SETS', 12 );
define( 'SHOP_CATEGORIES', FALSE );

function wrny_shop_alignments() {
	return array( 'left', 'right' );
}

function wrny_shop_headers() {
	return array( 'image', 'text' );
}

function wrny_shop_fields() {
	return array( 'image', 'link', 'caption' );
}

// action to add the panel to the editor page
function wrny_shop_add_admin_panel() {
	add_meta_box(
		'wrny_shop_editor',
		__('Shop Items'),
		'wrny_shop_editor',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'wrny_shop_add_admin_panel', 10 );
add_action( 'admin_init', 'wrny_shop_add_admin_panel', 10 );

// editor panel
function wrny_shop_editor() {

	global $post;

	// add nonce field
	wp_nonce_field( 'wrny_shop_meta_box', 'wrny_shop_meta_box_nonce' );

	// get saved post meta values
	$shop = array();
	
	/*
	$header = array();
	
	// header
	foreach( wrny_shop_alignments() as $a ) {
		$header[$a]['image'] = get_post_meta( $post->ID, 'wrny_shop_header_image_' . $a, true );
		$header[$a]['text'] = get_post_meta( $post->ID, 'wrny_shop_header_text_' . $a, true );
	}
	*/
	
	// items    
    for( $i = 1; $i <= SHOP_MAX_SETS; $i++ ) {
   		
   		// category
   		if ( defined( 'SHOP_CATEGORIES' ) && SHOP_CATEGORIES ) {
   			$shop[$i]['category'] = get_post_meta( $post->ID, 'wrny_shop_category_' . $i, true );
 		}

 		// data
 		foreach( wrny_shop_alignments() as $a ) {
			foreach( wrny_shop_fields() as $f ) {
				$shop[$i][$a][$f] = get_post_meta( $post->ID, 'wrny_shop_' . $f . '_' . $i . '_' . $a, true );
			}
 		}
 	}

 	// footer
 	//$footer = get_post_meta( $post->ID, 'wrny_shop_footer', true );

 	?>

	<div id="vp_main">
		<table class="form-table shop">
			<tbody>
			<?php

				$num_a = count( wrny_shop_alignments() );
				
				/*
				// header
				echo '<tr>';				
				foreach( wrny_shop_alignments() as $a ) {
					
					echo '<td class="col' . $num_a . ' header">';
					
					// image
					$field = 'wrny_shop_header_image_' . $a;
					$value = $header[$a]['image'];
					
					if( !empty( $value ) ) {
						$image = wp_get_attachment_image_src( $value, 'medium-square' );
						$image_html = ( !empty( $image[0] ) ) ? '<img src="' . $image[0] . '">' : '';
					} else {
						$image = '';
						$image_html = '';
					}
					
					echo '<div class="uploader">';
					echo '	<div class="shop_image_preview">' . $image_html . '</div>';
					echo '	<input class="shop_image" id="' . $field . '" name="' . $field . '" type="hidden" value="' . $value . '" />';
					echo '	<input class="image_button shop_set_image" type="button" value="Set Image" />';
					echo '	<input class="image_button shop_remove_image" type="button" value="Remove Image" />';
					echo '</div>';
					
					// header text
					$field = 'wrny_shop_header_text_' . $a;
					$value = $header[$a]['text'];
					echo '	<label for="' . $field . '">' . $a . ' Header</label>';
					echo '	<input type="text" id="' . $field . '" name="' . $field . '" value="' . $value . '" />';
					
					echo '</td>';
				}
				echo '</tr>';
				*/

				// items
				for( $i = 1; $i <= SHOP_MAX_SETS; $i++ ) {
					
					// category
					if ( defined( 'SHOP_CATEGORIES' ) && SHOP_CATEGORIES ) {

						$field = 'wrny_shop_category_' . $i;
						$value = $shop[$i]['category'];
						
						echo '<tr class="category">';
						echo '	<td colspan="2" scope="row">';
						echo '		<label for="' . $field . '">Category ' . $i . '</label>';
						echo '		<input type="text" id="' . $field . '" name="' . $field . '" class="shop-category" value="' . $value . '" />';
						echo '	</td>';
						echo '</tr>';
					}

					// data
					echo '<tr>';
					foreach( wrny_shop_alignments() as $a ) {
						
						echo '<td class="col' . $num_a . '">';
						
						// image
						$field = 'wrny_shop_image_' . $i . '_' . $a;
						$value = $shop[$i][$a]['image'];
						
						if( !empty( $value ) ) {
							$image = wp_get_attachment_image_src( $value, 'medium-square' );
							$image_html = ( !empty( $image[0] ) ) ? '<img src="' . $image[0] . '">' : '';
						} else {
							$image = '';
							$image_html = '';
						}
						
						echo '<div class="uploader">';
						echo '	<div class="shop_image_preview">' . $image_html . '</div>';
						echo '	<input class="shop_image" id="' . $field . '" name="' . $field . '" type="hidden" value="' . $value . '" />';
						echo '	<input class="image_button shop_set_image" type="button" value="Set Image" />';
						echo '	<input class="image_button shop_remove_image" type="button" value="Remove Image" />';
						echo '</div>';

						// link
						$field = 'wrny_shop_link_' . $i . '_' . $a;
						$value = $shop[$i][$a]['link'];
						echo '<label for="' . $field . '">Link ' . $i . ' ' . $a . '</label>';
						echo '<input type="text" id="' . $field . '" name="' . $field . '" value="' . $value . '" />';
						
						// caption
						$field = 'wrny_shop_caption_' . $i . '_' . $a;
						$value = $shop[$i][$a]['caption'];
						echo '<label for="' . $field . '">Caption ' . $i . ' ' . $a . '</label>';
						wp_editor( $value, $field, array(
							'teeny' => true,
							'media_buttons' => false,
							'quicktags' => false,
							'tinymce' => array(
						        'theme_advanced_buttons1' => 'bold,italic,underline',
						        'theme_advanced_buttons2' => '',
						        'theme_advanced_buttons3' => ''
						    )
						) );							
							
						echo '</td>';
					}

					echo '</tr>';					
				}
				
				/*
				
				// footer
				echo '<tr><td colspan="2">';

				// caption
				$field = 'wrny_shop_footer';
				$value = $footer;
				echo '<label for="' . $field . '">Footer Text</label>';
				wp_editor( $value, $field, array(
					'teeny' => true,
					'media_buttons' => false,
					'quicktags' => false,
					'tinymce' => array(
				        'theme_advanced_buttons1' => 'bold,italic,underline,link,unlink',
				        'theme_advanced_buttons2' => '',
				        'theme_advanced_buttons3' => ''
				    )
				) );
				echo '</td></tr>';
				
				*/

			?>		
			</tbody>
		</table>
	</div>

	<script type="text/javascript">
		
		jQuery(document).ready(function($) {
			
			/*
			
			##############
			# NOT NEEDED #
			##############
			
			// TOGGLE SHOP BOX BASED ON SELECTED CATEGORY
			
			$shop_cat = $('#categorychecklist').find("label:contains('items')").children('input:checkbox');
			$shop_box = $('#wrny_shop_editor');
			$pods_box = $('#pods-meta-more-fields');

			toggle_picks_fields();
			
			$shop_cat.click(function() {
				toggle_picks_fields();
			});	
			
			function toggle_picks_fields() {
				if( $shop_cat.is(':checked') ) {
					$shop_box.show();
					$pods_box.hide();					
				} else {
					$shop_box.hide();
					$pods_box.show();
				}		
			}
			*/

			// MEDIA UPLOAD
			
			var file_frame;
			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
			var set_to_post_id = <?php echo $post->ID; ?>; // Set this
			 
			$('.shop_set_image').on('click', function( event ) {
				
				event.preventDefault();
				$that = $(this);
			 
			    // If the media frame already exists, reopen it.
			    if ( file_frame ) {
					// Set the post ID to what we want
					file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
					// Open frame
					file_frame.open();
					return;
			    } else {
					// Set the wp.media post id so the uploader grabs the ID we want when initialised
					wp.media.model.settings.post.id = set_to_post_id;
			    }
			 
			    // Create the media frame.
			    file_frame = wp.media.frames.file_frame = wp.media({
					title: $( this ).data( 'uploader_title' ),
					button: {
						text: $( this ).data( 'uploader_button_text' ),
					},
					multiple: false  // Set to true to allow multiple files to be selected
			    });
			 
			    // When an image is selected, run a callback.
			    file_frame.on( 'select', function() {
					// We set multiple to false so only get one image from the uploader
					attachment = file_frame.state().get('selection').first().toJSON();

					// Do something with attachment.id and/or attachment.url here
					
					// save data
					$that.parent('.uploader').find('.shop_image').val( attachment.id );
					$that.parent('.uploader').find('.shop_image_preview').html('<img src="' + attachment.url + '">');
					
					// Restore the main post ID
					wp.media.model.settings.post.id = wp_media_post_id;
			    });
			 
			    // Finally, open the modal
			    file_frame.open();

			});
			  
			// Restore the main ID when the add media button is pressed
			$('a.add_media').on('click', function() {
				wp.media.model.settings.post.id = wp_media_post_id;
			});

			$('.shop_remove_image').on('click', function( event ) {
				console.log('remove image');
				$(this).parent('.uploader').find('.shop_image').val('');
				$(this).parent('.uploader').find('.shop_image_preview').html('');
					
			});
			
		});

	</script>
	<?php
}

// save meta values
function wrny_shop_save_meta_box( $post_id ) {

	// verify nonce
    if( isset( $_POST['wrny_shop_meta_box_nonce'] ) && !wp_verify_nonce( $_POST['wrny_shop_meta_box_nonce'], 'wrny_shop_meta_box' ) ) {
		return $post_id;
	}

	/*
	// check autosave
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
    */

    // Stop WP from clearing custom fields on autosave,
    // and also during ajax requests (e.g. quick edit) and bulk edits.
    if( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || (defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) {
    	return;
    }

    // save meta values if they are set
    if( isset( $_POST ) ) { 
	    
	    /*
	    // header
		foreach( wrny_shop_alignments() as $a ) {
			
			// image
			$field = 'wrny_shop_header_image_' . $a;
		    if( isset( $_POST[$field] ) ) {
			    update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
		    } else {
		        //delete_post_meta( $post_id, $field );
		    }

		    // text
		    $field = 'wrny_shop_header_text_' . $a;
		    if( isset( $_POST[$field] ) ) {
			    update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
		    } else {
		        //delete_post_meta( $post_id, $field );
		    }
		}
		*/

	    // items
	 	for( $i = 1; $i <= SHOP_MAX_SETS; $i++ ) {

	 		// category
	 		if ( defined( 'SHOP_CATEGORIES' ) && SHOP_CATEGORIES ) {
		   		if( isset( $_POST['wrny_shop_category_' . $i] ) ) {
			        update_post_meta( $post_id, 'wrny_shop_category_' . $i, sanitize_text_field( $_POST['wrny_shop_category_' . $i] ) );
			    } else {
			        //delete_post_meta( $post_id, 'wrny_shop_category_' . $i );
			    }
			}

	 		// items
	   		foreach( wrny_shop_alignments() as $a ) {
	   			foreach( wrny_shop_fields() as $f ) {
					$field = 'wrny_shop_' . $f . '_' . $i . '_' . $a;
					if( isset( $_POST[$field] ) ) {
				        update_post_meta( $post_id, $field, $_POST[$field] );
				    } else {
				        //delete_post_meta( $post_id, $field );
				    }
				}
			}
	    }
		
		/*
		
	    // footer
	    $field = 'wrny_shop_footer';
	    if( isset( $_POST[$field] ) ) {
	        update_post_meta( $post_id, $field, $_POST[$field] );
	    } else {
	        //delete_post_meta( $post_id, $field );
	    }
	    
	    */
	}
}
add_action( 'save_post', 'wrny_shop_save_meta_box' );

function wrny_shop_header() {
	
	/*
	echo '<div class="shop-header">';

	$data = wrny_shop_get_data();

	if( count( $data ) ) {

		echo '<div class="shop-row header">';
		
		foreach( wrny_shop_alignments() as $a ) {

			// image
			echo '<div class="shop-col ' . $a . '">';
			$image = wp_get_attachment_image_src( $data['header'][$a]['image'], 'medium-square' );
			if( !empty( $image[0] ) ) {
				echo '<img src="' . $image[0] . '">';
			}
			echo '</div><!--/.shop-col-->';	

		}
		
		echo '</div><!--/.shop-row-->';
		
	}

	the_content();

	echo '</div><!--/.shop-row-->';
	*/
	
}

function wrny_shop_content() {

	$data = wrny_shop_get_data();

	if( count( $data ) ) {
		
		echo '<div class="shop-content">';
		
		/*
		// header
		echo '<div class="shop-row header">';
		foreach( $data['header'] as $header ) {
			echo '<div class="shop-col">';
			echo '	<div class="header">' . $header['text'] . '</div>';
			echo '</div><!--/.shop-col-->';	
		}
		echo '</div><!--/.shop-row-->';
		*/

		foreach( $data['items'] as $k => $v ) {
			
			// data
			echo '<div class="shop-row">';
			foreach( wrny_shop_alignments() as $a ) {
				
				$link = $data['items'][$k][$a]['link'];
				$caption = $data['items'][$k][$a]['caption'];
				$image = wp_get_attachment_image_src( $data['items'][$k][$a]['image'], 'medium-square' );
				
				if( !empty( $image[0] ) ) {
					
					echo '<div class="shop-col ' . $a . '">';
					
					if( !empty( $link ) ) {
						echo '<a class="link" target="_blank" href="' . esc_url( $link ) . '">';
					}

					if( !empty( $image[0] ) ) {
						echo '<img src="' . $image[0] . '">';
					}

					if( !empty( $caption ) ) {
						echo '<div class="caption">' . $caption . '</div>';
					}
									
					// link close
					if( !empty( $link ) ) echo '</a>';

					echo '</div><!--/.shop-col-->';

				}	
			}
			echo '</div><!--/.shop-row-->';
		}
		
		/*

		// footer
		if( !empty( $data['footer'] ) ) {
			echo '<div class="shop-row footer">';
			echo $data['footer'];
			echo '</div><!--/.shop-row-->';
		}
		
		*/

		echo '</div>';
	}
}

// get post meta data
function wrny_shop_get_data() {

	global $post;

	$data = array();

	// header
	foreach( wrny_shop_alignments() as $a ) {
		foreach( wrny_shop_headers() as $f ) {
			$data['header'][$a][$f] = get_post_meta( $post->ID, 'wrny_shop_header_' . $f . '_' . $a, true );
		}
	}

    for( $i = 1; $i <= SHOP_MAX_SETS; $i++ ) {
   		
    	// category
    	if ( defined( 'SHOP_CATEGORIES' ) && SHOP_CATEGORIES ) {
   			$data['items'][$i]['category'] = get_post_meta( $post->ID, 'wrny_shop_category_' . $i, true );
 		}

 		// items
   		foreach( wrny_shop_alignments() as $a ) {
   			foreach( wrny_shop_fields() as $f ) {
				$data['items'][$i][$a][$f] = get_post_meta( $post->ID, 'wrny_shop_' . $f . '_' . $i . '_'. $a, true );
			}
		}
 	}

 	// footer
 	//$data['footer'] = get_post_meta( $post->ID, 'wrny_shop_footer', true );

 	return $data;
}