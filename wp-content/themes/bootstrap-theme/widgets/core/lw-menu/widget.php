<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_menu');

class lw_menu{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');

        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Menu', 'lw-menu', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){
        wp_nav_menu( array(
            'menu'  => 'Project Nav',
            'depth' => 2, 
            'container_class' => 'navbar navbar-expand-md navbar-light bg-light',
            'container' => 'nav',
            'menu_class' => 'navbar-nav mr-auto',
            'items_wrap' => 
                '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-menu-toggle" aria-controls="nav-menu-toggle" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>   
                <div class="collapse navbar-collapse" id="nav-menu-toggle">
                    <ul class="navbar-nav mr-auto">%3$s</ul>
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
    }
}
?>
