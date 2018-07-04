<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_textbox');

class lw_textbox{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');

        $fields_html = '';
        $fields_html .= get_textbox_html('Content', 'lw-textbox');
        $fields_html .= '<hr>';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Single Text', 'lw-textbox', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){        
        $text = '';
        if(is_array($arr)){  
            $text = $arr['lw-textbox']; 
        }
        echo $text;
    }
}
?>
