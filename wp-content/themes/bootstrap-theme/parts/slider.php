<?php  

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
add_action( 'init', 'lw_init_slider_category' );
 
function lw_create_slider() {	
    register_post_type( 'lw-slider',
        // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Slider', 'lw' ),
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
// Hooking up our function to theme setup
add_action( 'init', 'lw_create_slider' );  
?>