<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_editor'); 

class lw_editor{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');
        $fields_html ='';
        $fields_html .= get_textarea_html('Content', 'lw-editor'); 
        $fields_html .= get_checkbox_html('Execute shortcode', 'lw-execute-shortcode');
        $fields_html .= '<hr>';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('HTML/Text', 'lw-editor', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){    
        $html = '';
        if(is_array($arr)){ 
            $html = $arr['lw-editor']; 
        }

        if($arr['lw-execute-shortcode']){
            echo do_shortcode($html);
        }else{
            echo $html;        
        }
    }
}

?>
