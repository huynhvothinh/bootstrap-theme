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
require_once 'parts/template.php';
require_once 'parts/theme-setting.php';

// admin header
add_action('admin_head', 'my_custom_fonts');
function my_custom_fonts() {
    echo '<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">';
    echo '<link rel="stylesheet" href="/wp-content/themes/bootstrap-theme/assets-admin/css/styles.css">';
    echo '<script src="/wp-content/themes/bootstrap-theme/assets-admin/js/widget.js"></script>';
    echo '<script src="/wp-content/themes/bootstrap-theme/assets-admin/js/theme-setting.js"></script>';
}

// header menu
register_nav_menus( array( 
    'header' => 'Header menu'
));

function get_sidebar_tag_arr($position){ 
    $position_arr = array();
    
    if($position == 'left'){
        $position_arr['first'] = '
            <div class="row">
                <div class="col-md-3 col-12">';
        $position_arr['middle'] = '
                </div>
                <div class="col-md-9 col-12">';
        $position_arr['end'] = '
                </div>
            </div>';
    }else if($position == 'right'){
        $position_arr['first'] = '
            <div class="row">
                <div class="col-md-9 col-12">';
        $position_arr['middle'] = '
                </div>
                <div class="col-md-3 col-12">';
        $position_arr['end'] = '
                </div>
            </div>';
    } else {
        $position_arr['first'] = '';
        $position_arr['middle'] = '';
        $position_arr['end'] = '';
    }
    return $position_arr;
}
?>
