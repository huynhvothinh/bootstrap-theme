<?php
function lw_wp_nav_menu($menu) {    
    $menu = preg_replace('/ class="menu-item /',' class="menu-item nav-item ',$menu); 
    $menu = preg_replace('/ href="/',' class="nav-link" href="',$menu); 
    
    $menu = preg_replace('/ menu-item-has-children/',' menu-item-has-children dropdown',$menu); 
    $menu = preg_replace('/ class="sub-menu/',' class="sub-menu dropdown-menu navbar-light bg-light',$menu);        
    return $menu;      
}
add_filter('wp_nav_menu','lw_wp_nav_menu'); 
?>