<?php 
global $lw_widget_arr; 
$lw_widget_arr = array();

// support thumbnail for custom post type
add_theme_support( 'post-thumbnails' );  

// load widgets
require_once 'widgets/custom-option.php';
require_once 'widgets/custom-widget.php';

// load custom parts
require_once 'parts/sidebar.php';
require_once 'parts/nav.php';
require_once 'parts/logo.php';
require_once 'parts/slider.php';

// admin header
add_action('admin_head', 'my_custom_fonts');
function my_custom_fonts() {
    echo '<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">';
    echo '<link rel="stylesheet" href="/wp-content/themes/bootstrap-theme/assets-admin/css/styles.css">';
    echo '<script src="/wp-content/themes/bootstrap-theme/assets-admin/js/scripts.js"></script>';
}

// header menu
register_nav_menus( array( 
    'header' => 'Header menu'
));

?>
