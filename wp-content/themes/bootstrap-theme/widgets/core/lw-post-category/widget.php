<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_post_category');

class lw_post_category{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');
        $fields_html ='';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Post category', 'lw-post-category', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){
        ?>
        <div class="lw-post-category">
            <h5>
            <?php
                global $single;
                if($single){
                    $category = get_the_category($single->ID);
                    $first_category = $category[0];
                    echo sprintf( '<a href="%s">%s</a>', get_category_link( $first_category ), $first_category->name );
                }
            ?>
            </h5>
        </div>
        <?php
    }
}

?>
