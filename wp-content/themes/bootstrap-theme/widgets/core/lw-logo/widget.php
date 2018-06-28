<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_logo');

class lw_logo{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');

        $fields_html ='';
        $fields_html .= get_textarea_html('Logo', 'lw-logo'); 
        $fields_html .= '<hr>';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Logo', 'lw-logo', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){
        if ( function_exists( 'the_custom_logo' ) ) {
            the_custom_logo();
        }
    }
}
?>
