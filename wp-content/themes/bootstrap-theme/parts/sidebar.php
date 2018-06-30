<?php
function lw_register_sidebars() {
    register_sidebar( array(
        'name' => 'Header sidebar',
        'id' => 'lw_header_sidebar',
        'before_widget' => '<div class="lw-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="lw-widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar( array(
        'name' => 'Sidebar',
        'id' => 'lw_sidebar',
        'before_widget' => '<div class="lw-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="lw-widget-title">',
        'after_title' => '</h3>',
    )); 
    register_sidebar( array(
        'name' => 'Footer sidebar',
        'id' => 'lw_footer_sidebar',
        'before_widget' => '<div class="lw-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="lw-widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar( array(
        'name' => 'Hidden sidebar',
        'id' => 'lw_hidden_sidebar',
        'before_widget' => '<div class="lw-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="lw-widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action( 'widgets_init', 'lw_register_sidebars' );
?>