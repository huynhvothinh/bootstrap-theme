<?php  
add_action( 'init', 'lw_init_slider_category' );
function lw_init_slider_category() { 
	$labels = array(
		'name' => _x( 'Slider category', 'taxonomy general name' ),
		'singular_name' => _x( 'Slider category', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Slider category' ),
		'all_items' => __( 'All Slider category' ),
		'parent_item' => __( 'Parent Slider category' ),
		'parent_item_colon' => __( 'Parent Slider category:' ),
		'edit_item' => __( 'Edit Slider category' ), 
		'update_item' => __( 'Update Slider category' ),
		'add_new_item' => __( 'Add New Slider category' ),
		'new_item_name' => __( 'New Slider category Name' ),
		'menu_name' => __( 'Slider category' ),
	  );    
	 
	// Now register the taxonomy	 
	register_taxonomy('lw-slider-category',array('lw-slider'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'lw-slider-category' ),
	));
}
 
// Hooking up our function to theme setup
add_action( 'init', 'lw_create_slider' );  
function lw_create_slider() {	
    register_post_type( 'lw-slider',
        // CPT Options
        array(
            'labels' => array(
                'name' => __( 'LW Slider', 'lw' ),
                'singular_name' => __( 'lw-slider' )
            ),
            'public' => true,
            'has_archive' => true,
			'rewrite' => array('slug' => 'lw-slider'),
			'hierarchical'        => false,  
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => false,
			'has_archive'         => false,
			'exclude_from_search' => true, 
            'supports' => array( 'title', 'editor', 'thumbnail' ),
			'taxonomies' 		  => array( 'lw-slider-category' ),
        )
    );
}

/*
	SLIDER CUSTOM FIELDS
*/
/* Define the custom box */
// WP 3.0+
add_action( 'add_meta_boxes', 'slider_options' );
// backwards compatible
add_action( 'admin_init', 'slider_options', 1 );
function slider_options() { 
    add_meta_box( 'post_options_all', __( 'Slider Info' ), 'slider_options_fields', ['lw-slider'], 'normal', 'high' );
}
function slider_options_fields($post){
    wp_nonce_field( plugin_basename( __FILE__ ), $post->post_type . '_noncename' );
?>
    <table style="width:100%; max-width:600px;">
        <tbody>
            <tr>
                <td>Slider info 1</td>
				<td>
					<input type="text" id="lw_slider_info_1" name="lw_slider_info_1" style="width:100%;"
					value="<?php echo get_post_meta( $post->ID, 'lw_slider_info_1', true);?>">
				</td>
            </tr> 
            <tr>
                <td>Slider info 2</td>
				<td>
					<input type="text" id="lw_slider_info_2" name="lw_slider_info_2" style="width:100%;"
					value="<?php echo get_post_meta( $post->ID, 'lw_slider_info_2', true);?>">
				</td>
            </tr> 
        </tbody>
    </table>
<?php
}

/* Do something with the data entered */
add_action( 'save_post', 'save_slider_options' ); 
function save_slider_options( $post_id ) {
    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !wp_verify_nonce( @$_POST[$_POST['post_type'] . '_noncename'], plugin_basename( __FILE__ ) ) )
        return;

    // Check permissions
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;

    // OK, we're authenticated: we need to find and save the data
    if( 'lw-slider' == $_POST['post_type']) { 
        if(isset($_POST['lw_slider_info_1']))
            update_post_meta( $post_id, 'lw_slider_info_1', $_POST['lw_slider_info_1'] );              

        if(isset($_POST['lw_slider_info_2']))
            update_post_meta( $post_id, 'lw_slider_info_2', $_POST['lw_slider_info_2'] ); 
    }
}

?>