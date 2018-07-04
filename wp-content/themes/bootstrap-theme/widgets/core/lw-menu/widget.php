<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_menu');

class lw_menu{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');

        $items = array();
        array_push($items, array());
        array_push($items, array());
        $items[0]['text'] = 'Header';
        $items[0]['value'] = 'header';
        $items[1]['text'] = 'Footer';
        $items[1]['value'] = 'footer';

        $fields_html .= get_select_html('Menu location', 'lw-menu-location', $items);
        $fields_html .= '<hr>';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Menu', 'lw-menu', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){
        $menu_location = 'header';
        if(isset($arr['lw-menu-location'])){
            $menu_location = $arr['lw-menu-location'];
        }

        if($menu_location == 'header'){
            wp_nav_menu( array(
                'theme_location'  => $menu_location,
                'depth' => 2, 
                'container_class' => 'navbar navbar-expand-md navbar-light lw-menu-header',
                'container' => 'nav',
                'menu_class' => 'navbar-nav',
                'items_wrap' => 
                    '<button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#nav-menu-toggle" aria-controls="nav-menu-toggle" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"> 
                        </span>
                    </button>   
                    <div class="collapse navbar-collapse" id="nav-menu-toggle">
                        <ul class="navbar-nav">%3$s</ul>
                    </div>'
            ) );
            ?>
            <script>
                jQuery(document).ready(function(){
                    var menu = jQuery('.lw-menu');
                    jQuery(menu).find('.menu-item-has-children >a')
                        .attr('data-toggle', 'dropdown')
                        .addClass('dropdown-toggle');
                    jQuery(menu).find('.dropdown-menu li')
                        .addClass('dropdown-item');
                });
            </script>
            <?php
        }else{
            wp_nav_menu( array(
                'theme_location'  => $menu_location,
                'depth' => 1, 
                'container_class' => 'lw-menu-footer',
                'items_wrap' => '<ul class="nav justify-content-center">%3$s</ul>'
            ) );
        }
    }
}
?>
