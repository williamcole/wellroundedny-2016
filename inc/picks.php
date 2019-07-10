<?php

#########
# PICKS #
#########

// config
define( 'PICKS_MAX_SETS', 12 );
define( 'PICKS_CATEGORIES', FALSE );

function wrny_picks_alignments() {
	return array( 'left', 'right' );
}

function wrny_picks_headers() {
	return array( 'image', 'text' );
}

function wrny_picks_fields() {
	return array( 'image', 'link', 'caption' );
}

// action to add the panel to the editor page
function wrny_picks_add_admin_panel() {
	add_meta_box(
		'wrny_picks_editor',
		__('Editors Picks'),
		'wrny_picks_editor',
		'post',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'wrny_picks_add_admin_panel', 10 );
add_action( 'admin_init', 'wrny_picks_add_admin_panel', 10 );

// editor panel
function wrny_picks_editor() {

	global $post;

	// add nonce field
	wp_nonce_field( 'wrny_picks_meta_box', 'wrny_picks_meta_box_nonce' );

	// get saved post meta values
	$header = array();
	$picks = array();
	
	// header
	foreach( wrny_picks_alignments() as $a ) {
		$header[$a]['image'] = get_post_meta( $post->ID, 'wrny_picks_header_image_' . $a, true );
		$header[$a]['text'] = get_post_meta( $post->ID, 'wrny_picks_header_text_' . $a, true );
	}

	// picks    
    for( $i = 1; $i <= PICKS_MAX_SETS; $i++ ) {
   		
   		// category
   		if ( defined( 'PICKS_CATEGORIES' ) && PICKS_CATEGORIES ) {
   			$picks[$i]['category'] = get_post_meta( $post->ID, 'wrny_picks_category_' . $i, true );
 		}

 		// data
 		foreach( wrny_picks_alignments() as $a ) {
			foreach( wrny_picks_fields() as $f ) {
				$picks[$i][$a][$f] = get_post_meta( $post->ID, 'wrny_picks_' . $f . '_' . $i . '_' . $a, true );
			}
 		}
 	}

 	// footer
 	$footer = get_post_meta( $post->ID, 'wrny_picks_footer', true );

 	?>

	<div id="vp_main">
		<table class="form-table picks">
			<tbody>
			<?php

				$num_a = count( wrny_picks_alignments() );
				
				// header
				echo '<tr>';				
				foreach( wrny_picks_alignments() as $a ) {
					
					echo '<td class="col' . $num_a . ' header">';
					
					// image
					$field = 'wrny_picks_header_image_' . $a;
					$value = $header[$a]['image'];
					
					if( !empty( $value ) ) {
						$image = wp_get_attachment_image_src( $value, 'medium-square' );
						$image_html = ( !empty( $image[0] ) ) ? '<img src="' . $image[0] . '">' : '';
					} else {
						$image = '';
						$image_html = '';
					}
					
					echo '<div class="uploader">';
					echo '	<div class="pick_image_preview">' . $image_html . '</div>';
					echo '	<input class="pick_image" id="' . $field . '" name="' . $field . '" type="hidden" value="' . $value . '" />';
					echo '	<input class="image_button pick_set_image" type="button" value="Set Image" />';
					echo '	<input class="image_button pick_remove_image" type="button" value="Remove Image" />';
					echo '</div>';
					
					// header text
					$field = 'wrny_picks_header_text_' . $a;
					$value = $header[$a]['text'];
					echo '	<label for="' . $field . '">' . $a . ' Header</label>';
					echo '	<input type="text" id="' . $field . '" name="' . $field . '" value="' . $value . '" />';
					
					echo '</td>';
				}
				echo '</tr>';

				// picks
				for( $i = 1; $i <= PICKS_MAX_SETS; $i++ ) {
					
					// category
					if ( defined( 'PICKS_CATEGORIES' ) && PICKS_CATEGORIES ) {

						$field = 'wrny_picks_category_' . $i;
						$value = $picks[$i]['category'];
						
						echo '<tr class="category">';
						echo '	<td colspan="2" scope="row">';
						echo '		<label for="' . $field . '">Category ' . $i . '</label>';
						echo '		<input type="text" id="' . $field . '" name="' . $field . '" class="pick-category" value="' . $value . '" />';
						echo '	</td>';
						echo '</tr>';
					}

					// data
					echo '<tr>';
					foreach( wrny_picks_alignments() as $a ) {
						
						echo '<td class="col' . $num_a . '">';
						
						// image
						$field = 'wrny_picks_image_' . $i . '_' . $a;
						$value = $picks[$i][$a]['image'];
						
						if( !empty( $value ) ) {
							$image = wp_get_attachment_image_src( $value, 'medium-square' );
							$image_html = ( !empty( $image[0] ) ) ? '<img src="' . $image[0] . '">' : '';
						} else {
							$image = '';
							$image_html = '';
						}
						
						echo '<div class="uploader">';
						echo '	<div class="pick_image_preview">' . $image_html . '</div>';
						echo '	<input class="pick_image" id="' . $field . '" name="' . $field . '" type="hidden" value="' . $value . '" />';
						echo '	<input class="image_button pick_set_image" type="button" value="Set Image" />';
						echo '	<input class="image_button pick_remove_image" type="button" value="Remove Image" />';
						echo '</div>';

						// link
						$field = 'wrny_picks_link_' . $i . '_' . $a;
						$value = $picks[$i][$a]['link'];
						echo '<label for="' . $field . '">Link ' . $i . ' ' . $a . '</label>';
						echo '<input type="text" id="' . $field . '" name="' . $field . '" value="' . $value . '" />';
						
						// caption
						$field = 'wrny_picks_caption_' . $i . '_' . $a;
						$value = $picks[$i][$a]['caption'];
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

				// footer
				echo '<tr><td colspan="2">';

				// caption
				$field = 'wrny_picks_footer';
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

			?>		
			</tbody>
		</table>
	</div>

	<script type="text/javascript">
		
		jQuery(document).ready(function($) {
			
			// TOGGLE PICKS BOX BASED ON SELECTED CATEGORY
			
			$picks_cat = $('#categorychecklist').find("label:contains('Picks')").children('input:checkbox');
			$picks_box = $('#wrny_picks_editor');
			$pods_box = $('#pods-meta-more-fields');

			toggle_picks_fields();
			
			$picks_cat.click(function() {
				toggle_picks_fields();
			});	
			
			function toggle_picks_fields() {
				if( $picks_cat.is(':checked') ) {
					$picks_box.show();
					$pods_box.hide();					
				} else {
					$picks_box.hide();
					$pods_box.show();
				}		
			}

			// MEDIA UPLOAD
			
			var file_frame;
			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
			var set_to_post_id = <?php echo $post->ID; ?>; // Set this
			 
			$('.pick_set_image').on('click', function( event ) {
				
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
					$that.parent('.uploader').find('.pick_image').val( attachment.id );
					$that.parent('.uploader').find('.pick_image_preview').html('<img src="' + attachment.url + '">');
					
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

			$('.pick_remove_image').on('click', function( event ) {
				console.log('remove image');
				$(this).parent('.uploader').find('.pick_image').val('');
				$(this).parent('.uploader').find('.pick_image_preview').html('');
					
			});
			
		});

	</script>
	<?php
}

// save meta values
function wrny_picks_save_meta_box( $post_id ) {

	// verify nonce
    if( isset( $_POST['wrny_picks_meta_box_nonce'] ) && !wp_verify_nonce( $_POST['wrny_picks_meta_box_nonce'], 'wrny_picks_meta_box' ) ) {
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
	    
	    // header
		foreach( wrny_picks_alignments() as $a ) {
			
			// image
			$field = 'wrny_picks_header_image_' . $a;
		    if( isset( $_POST[$field] ) ) {
			    update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
		    } else {
		        //delete_post_meta( $post_id, $field );
		    }

		    // text
		    $field = 'wrny_picks_header_text_' . $a;
		    if( isset( $_POST[$field] ) ) {
			    update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
		    } else {
		        //delete_post_meta( $post_id, $field );
		    }
		}

	    // picks
	 	for( $i = 1; $i <= PICKS_MAX_SETS; $i++ ) {

	 		// category
	 		if ( defined( 'PICKS_CATEGORIES' ) && PICKS_CATEGORIES ) {
		   		if( isset( $_POST['wrny_picks_category_' . $i] ) ) {
			        update_post_meta( $post_id, 'wrny_picks_category_' . $i, sanitize_text_field( $_POST['wrny_picks_category_' . $i] ) );
			    } else {
			        //delete_post_meta( $post_id, 'wrny_picks_category_' . $i );
			    }
			}

	 		// picks
	   		foreach( wrny_picks_alignments() as $a ) {
	   			foreach( wrny_picks_fields() as $f ) {
					$field = 'wrny_picks_' . $f . '_' . $i . '_' . $a;
					if( isset( $_POST[$field] ) ) {
				        update_post_meta( $post_id, $field, $_POST[$field] );
				    } else {
				        //delete_post_meta( $post_id, $field );
				    }
				}
			}
	    }

	    // footer
	    $field = 'wrny_picks_footer';
	    if( isset( $_POST[$field] ) ) {
	        update_post_meta( $post_id, $field, $_POST[$field] );
	    } else {
	        //delete_post_meta( $post_id, $field );
	    }
	}
}
add_action( 'save_post', 'wrny_picks_save_meta_box' );

// markup for editors picks content
function wrny_picks_header() {
	
	echo '<div class="picks-header">';

	$data = wrny_picks_get_data();

	if( count( $data ) ) {

		echo '<div class="picks-row header">';
		
		foreach( wrny_picks_alignments() as $a ) {

			// image
			echo '<div class="picks-col ' . $a . '">';
			$image = wp_get_attachment_image_src( $data['header'][$a]['image'], 'medium-square' );
			if( !empty( $image[0] ) ) {
				echo '<img src="' . $image[0] . '">';
			}
			echo '</div><!--/.picks-col-->';	

		}
		
		echo '</div><!--/.picks-row-->';
		
	}

	the_content();

	echo '</div><!--/.picks-row-->';
}

// markup for editors picks content
function wrny_picks_content() {

	$data = wrny_picks_get_data();

	if( count( $data ) ) {
		
		echo '<div class="picks-content">';

		// header
		echo '<div class="picks-row header">';
		foreach( $data['header'] as $header ) {
			echo '<div class="picks-col">';
			echo '	<div class="header">' . $header['text'] . '</div>';
			echo '</div><!--/.picks-col-->';	
		}
		echo '</div><!--/.picks-row-->';

		foreach( $data['picks'] as $k => $v ) {
			
			/*
			
			// category
			if ( defined( 'PICKS_CATEGORIES' ) && PICKS_CATEGORIES ) {
				# TODO
			}

			*/
			
			// data
			echo '<div class="picks-row">';
			foreach( wrny_picks_alignments() as $a ) {
				
				$link = $data['picks'][$k][$a]['link'];
				$caption = $data['picks'][$k][$a]['caption'];
				$image = wp_get_attachment_image_src( $data['picks'][$k][$a]['image'], 'medium-square' );
				
				if( !empty( $image[0] ) ) {
					
					echo '<div class="picks-col ' . $a . '">';
					
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

					echo '</div><!--/.picks-col-->';

				}	
			}
			echo '</div><!--/.picks-row-->';
		}

		// footer
		if( !empty( $data['footer'] ) ) {
			echo '<div class="picks-row footer">';
			echo $data['footer'];
			echo '</div><!--/.picks-row-->';
		}

		echo '</div>';
	}
}

// get post meta data for picks
function wrny_picks_get_data() {

	global $post;

	$data = array();

	// header
	foreach( wrny_picks_alignments() as $a ) {
		foreach( wrny_picks_headers() as $f ) {
			$data['header'][$a][$f] = get_post_meta( $post->ID, 'wrny_picks_header_' . $f . '_' . $a, true );
		}
	}

    for( $i = 1; $i <= PICKS_MAX_SETS; $i++ ) {
   		
    	// category
    	if ( defined( 'PICKS_CATEGORIES' ) && PICKS_CATEGORIES ) {
   			$data['picks'][$i]['category'] = get_post_meta( $post->ID, 'wrny_picks_category_' . $i, true );
 		}

 		// picks
   		foreach( wrny_picks_alignments() as $a ) {
   			foreach( wrny_picks_fields() as $f ) {
				$data['picks'][$i][$a][$f] = get_post_meta( $post->ID, 'wrny_picks_' . $f . '_' . $i . '_'. $a, true );
			}
		}
 	}

 	// footer
 	$data['footer'] = get_post_meta( $post->ID, 'wrny_picks_footer', true );

 	return $data;
}