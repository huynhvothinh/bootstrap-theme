<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_post_content');

class lw_post_content{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');
        $fields_html ='';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Post/Page content', 'lw-post-content', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){
        ?>
        <div class="lw-post-content">  
            <?php
                global $single; 
                echo $single->post_content;
            ?> 
        </div>
        <?php
    }
}

?>
