<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_tag');

class lw_tag{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');
        $fields_html ='';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Tag', 'lw-tag', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){
        ?>
        <div class="lw-tag"> 
            <?php
                $tags = get_tags();
                $html = '<ul>';
                foreach ( $tags as $tag ) {
                    $tag_link = get_tag_link( $tag->term_id );
                    $html .= "<li><a href='{$tag_link}' class='{$tag->slug}'>";
                    $html .= "{$tag->name}</a></li>";
                }
                $html .= '</ul>';
                echo $html;
            ?> 
        </div>
        <?php
    }
}

?>
