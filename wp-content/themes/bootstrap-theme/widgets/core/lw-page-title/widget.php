<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_page_title');

class lw_page_title{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');
        $fields_html ='';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Page title', 'lw-page-title', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){
        ?>
        <div class="lw-page-title">
            <h2>
            <?php
                global $single;
                if(is_tag()){
                    echo single_tag_title('', false);
                }else if(is_search()){
                    echo __('Search', 'lw');
                }else if(is_page()){
                    echo $single->post_title;
                }else if(is_single()){
                    echo $single->post_title;
                }else if ( is_archive() ) {
                    echo single_cat_title();
                }
            ?>
            </h2>
        </div>
        <?php
    }
}

?>
