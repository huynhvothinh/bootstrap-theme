<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_post_thumbnail');

class lw_post_thumbnail{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');
        
        $image_sizes = get_thumbnail_size_arr();

        $fields_html .= get_select_html('Image size', 'lw-image-size', $image_sizes);
        $fields_html .= '<hr>';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Post thumbnail', 'lw-post-thumbnail', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){ 
        $image_size = 'full'; 
        if(is_array($arr)){  
            if(isset($arr['lw-image-size'])){
                $image_size = $arr['lw-image-size']; 
            } 
        } 
        
        global $single; 
        ?>
        <div class="lw-post-thumbnail">
            <?php echo get_the_post_thumbnail( $single->ID, $image_size);?>
            <div class="lw-image-layer"></div>
        </div>
        <?php
    }
}
?>
