<?php
function get_field_box_html($field_title, $field_html){
    return '<div class="field box">
        <div class="title field-title"><div>'.$field_title.'</div></div>
        <div class="body field-body">'.$field_html.'</div>
    </div>';
}
function get_field_group_html($group_title, $group_key, $fields_html){
    return '<div widget-name="'.$group_key.'" class="'.$group_key.' field-group box">
        <div class="header field-group-header"><div>'.$group_title.'</div></div>
        <div class="body field-group-body"><div class="widget-fields" widget-name="'.$group_key.'">'.$fields_html.'</div></div>
    </div>';
}
function get_popup_html($key, $body_html){
    return '<div><div class="lw-'.$key.'-setting lw-popup">
        <div class="lw-popup-content">
            <div class="lw-popup-header setting-header"><a class="close" href="#">Close</a></div>
            <div class="lw-popup-body">
                '.$body_html.'
            </div>
        </div>
    </div></div>';
}
// ==========================================================
function get_textarea_html($title, $key, $is_setting=false){
    $plus_key = 'field-value';
    if($is_setting) $plus_key = 'setting';
    $html = '<textarea rows="4" cols="50" field-key="'.$key.'" class="'.$key.' '.$plus_key.' lw-editor textarea"> </textarea>';
    $html .= '<br><a href="#" class="lw-editor-call">Editor</a>';
    $result = get_field_box_html($title, $html);
    return $result;
}
function get_textbox_html($title, $key, $is_setting=false){ 
    $plus_key = 'field-value';
    if($is_setting) $plus_key = 'setting';
    $html = '<input type="text" field-key="'.$key.'" class="'.$key.' '.$plus_key.' textbox ">';
    $result = get_field_box_html($title, $html);
    return $result;
}
function get_checkbox_html($title, $key, $is_setting=false){ 
    $plus_key = 'field-value';
    if($is_setting) $plus_key = 'setting';
    $html = '<input type="checkbox" field-key="'.$key.'" class="'.$key.' '.$plus_key.' checkbox ">';
    $result = get_field_box_html($title, $html);
    return $result;
}
function get_select_html($title, $key, $items){
    $plus_key = 'field-value'; 
    $html = '';
    $html .= '<select field-key="'.$key.'" class="'.$key.' '.$plus_key.' select">';
    foreach($items as $item){
        $html .= '<option value="'.$item['value'].'">'.$item['text'].'</option>';
    }
    $html .= '</select>';
    $result = get_field_box_html($title, $html);
    return $result;
}
function get_item_setting_html(){
    $html = get_textbox_html('Item name', 'lw-name', true);
    $html .= get_checkbox_html('Display name', 'lw-display-name', true);
    $html .= get_textbox_html('CSS class', 'lw-css-class', true);
    return $html;
}
function get_column_setting_html(){
    $html = get_textbox_html('Column name', 'lw-name', true);
    $html .= get_checkbox_html('Display name', 'lw-display-name', true);
    $html .= get_textbox_html('CSS class', 'lw-css-class', true);
    return get_popup_html('column', $html);
}
function get_row_setting_html(){
    $html = get_textbox_html('Row name', 'lw-name', true);
    $html .= get_checkbox_html('Display name', 'lw-display-name', true);
    $html .= get_textbox_html('CSS class', 'lw-css-class', true);    
    return get_popup_html('row', $html);
}
?>