<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_short_news'); 

class lw_short_news{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');
        $fields_html ='';
        $fields_html .= get_textbox_html('Title', 'lw-title');
        $fields_html .= get_textarea_html('Image', 'lw-image'); 
        $fields_html .= get_textarea_html('Short content', 'lw-content'); 
        $fields_html .= get_textarea_html('Button', 'lw-button'); 
        $fields_html .= '<hr>';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Short news', 'lw-short-news', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){    
        $title = '';
        $image = '';
        $content = '';
        $button = '';

        if(is_array($arr)){
            foreach($arr as $field){
                if($field->field == 'lw-title'){
                    $title = $field->value;
                }else if($field->field == 'lw-image'){
                    $image = $field->value;
                }else if($field->field == 'lw-content'){
                    $content = $field->value;
                }else if($field->field == 'lw-button'){
                    $button = $field->value;
                }
            }
        }
    ?>
        <h3 class="lw-title"><?php echo $title;?></h3>
        <div class="lw-image"><?php echo $image;?></div>
        <div class="lw-content"><?php echo $content;?></div>
        <div class="lw-button"><?php echo $button;?></div>
    <?php        
    }
}

?>
