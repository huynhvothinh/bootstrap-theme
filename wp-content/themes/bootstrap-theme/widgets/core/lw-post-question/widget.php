<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_post_question');

class lw_post_question{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');

        $fields_html .= get_textbox_html('Post ID', 'lw-post-id');
        $fields_html .= '<hr>';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Post question', 'lw-post-question', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){ 
        $post_id = $arr['lw-post-id'];         
        $post = get_post($post_id);
        ?>
        <div class="lw-post-question">
            <h5 class="lw-question-title"><?php echo $post->post_title;?></h5>
            <div class="lw-question-content"><?php echo $post->post_content;?></div>
        </div>

        <script>
            jQuery(document).ready(function(){
                jQuery('.lw-question-content>ul>li').click(function(){
                    jQuery('.lw-question-content>ul>li ul').hide();
                    jQuery(this).find('ul').show();
                });
            });
        </script>
        <?php
    }
}
?>
