<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_setting');

class lw_setting{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');

        $setting_html = get_column_setting_html(); 
        $setting_html .= get_row_setting_html(); 
        echo $setting_html;
    }
    public function widget($arr){
        
    }
}
?>
