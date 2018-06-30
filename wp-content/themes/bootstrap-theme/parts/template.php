<?php  
 
function lw_create_template() {	
    register_post_type( 'lw-template',
        // CPT Options
        array(
            'labels' => array(
                'name' => __( 'LW Template', 'lw' ),
                'singular_name' => __( 'lw-template' )
            ),
            'public' => true,
            'has_archive' => true,
			'rewrite' => array('slug' => 'lw-template'),
			'hierarchical'        => false,  
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => false,
			'has_archive'         => false,
			'exclude_from_search' => true, 
            'supports' => array( 'title' ), 
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'lw_create_template' );  
?>