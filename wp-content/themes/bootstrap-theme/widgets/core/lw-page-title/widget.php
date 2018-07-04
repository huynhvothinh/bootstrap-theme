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
                if ( is_archive() ) {
                    echo __('Category: ', 'lw').get_the_archieve_title();
                }else if(is_search()){
                    echo __('Search', 'lw');
                }else if(is_post() || is_page()){
                    echo get_the_title();
                }else if(is_tag()){
                    $tag = get_tag();
                    echo __('Tag: ', 'lw').$tag->name;
                }
            ?>
            </h2>
        </div>
        <?php
    }
}

?>
