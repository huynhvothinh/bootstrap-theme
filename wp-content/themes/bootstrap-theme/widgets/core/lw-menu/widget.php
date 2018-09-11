<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_menu');

class lw_menu{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');

        $locations = array();        
        array_push($locations, array());
        array_push($locations, array());
        array_push($locations, array());
        $locations[0]['text'] = 'Header';
        $locations[0]['value'] = 'header';
        $locations[1]['text'] = 'Nav';
        $locations[1]['value'] = 'nav';
        $locations[2]['text'] = 'Custom';
        $locations[2]['value'] = 'custom';

        $items = array();  
        $item = array();
        $item['text'] = '-- Menu by Category name --';
        $item['value'] = 'by_category';
        array_push($items, $item);

        $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) ); 
        for($i=0;$i<count($menus);$i++){
            $item = array();
            $item['text'] = $menus[$i]->name;
            $item['value'] = $menus[$i]->term_id;
            array_push($items, $item);
        }

        $fields_html .= get_select_html('Menu location', 'lw-menu-location', $locations);
        $fields_html .= get_select_html('Menu item', 'lw-menu-item', $items);
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
        if(isset($arr['lw-menu-item'])){
            $menu_item = $arr['lw-menu-item'];
        }

        $menu_name = NULL;
        if($menu_item == 'by_category'){
            $menu_item = NULL;

            global $single;
            if($single){
                $cat_arr = get_the_category($single->ID);
                if($cat_arr && count($cat_arr)>0){
                    $menu_name = $cat_arr[0]->name;
                }
            }else{
                $menu_name = single_cat_title('', false);
            }
        }

        if($menu_location == 'header'){
            wp_nav_menu( array(
                'menu' => $menu_name,
                'theme_location'  => $menu_location,
                'menu_id' => $menu_item,
                'depth' => 0, 
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
                    </div>',
                'fallback_cb'    => false
            ) );
            ?>
            <script>
                jQuery(document).ready(function(){
                    var menu = jQuery('.lw-menu .lw-menu-header');
                    jQuery(menu).find('.menu-item-has-children >a')
                        .attr('data-toggle', 'dropdown')
                        .addClass('dropdown-toggle');
                    jQuery(menu).find('.dropdown-menu li')
                        .addClass('dropdown-item');
                });
            </script>
            <?php
        }else if($menu_location == 'nav'){
            wp_nav_menu( array(
                'menu' => $menu_name,
                'menu_id'  => $menu_item,
                'depth' => 0, 
                'container_class' => 'lw-menu-footer',
                'items_wrap' => '<ul class="nav justify-content-center">%3$s</ul>',
                'fallback_cb'    => false
            ) );
        }else{   
            wp_nav_menu( array(
                'menu' => $menu_name,
                'menu_id'  => $menu_item,
                'depth' => 0, 
                'items_wrap' => '<ul class="lw-menu-custom">%3$s</ul>',
                'fallback_cb'    => false
            ) );
            ?>
            <script>
                jQuery('.lw-menu-custom .menu-item-has-children > a').click(function(e){
                    e.preventDefault();
                    jQuery(this).parent().find('>.sub-menu').toggleClass('show');
                })
            </script>
            <?php
        }
    }
}
?>
