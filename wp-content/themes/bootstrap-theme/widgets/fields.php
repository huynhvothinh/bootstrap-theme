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
function get_textarea_html_simple($title, $key, $is_setting=false){
    $plus_key = 'field-value';
    if($is_setting) $plus_key = 'setting';
    $html = '<textarea rows="4" cols="50" field-key="'.$key.'" class="'.$key.' '.$plus_key.' lw-editor textarea"> </textarea>';
    $result = get_field_box_html($title, $html);
    return $result;
}
function get_textbox_html($title, $key, $is_setting=false, $default_value=''){ 
    $plus_key = 'field-value';
    if($is_setting) $plus_key = 'setting';
    $html = '<input type="text" field-key="'.$key.'" class="'.$key.' '.$plus_key.' textbox " value="'.$default_value.'">';
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
function get_select_html($title, $key, $items, $is_setting=false){
    $plus_key = 'field-value'; 
    if($is_setting) $plus_key = 'setting';
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
    $html .= getClassExample();
    $html .= get_textbox_html('Background image url', 'lw-background-image-url', true);
    $html .= get_textarea_html_simple('Style css', 'lw-style-css', true);
    $html .= getCssExample();
    return $html;
}
function get_column_setting_html(){
    $html = get_textbox_html('Column name', 'lw-name', true);
    $html .= get_checkbox_html('Display name', 'lw-display-name', true);
    $html .= get_textbox_html('CSS class', 'lw-css-class', true);  
    $html .= getClassExample();  
    $html .= get_textbox_html('Background image url', 'lw-background-image-url', true);
    $html .= get_textarea_html_simple('Style css', 'lw-style-css', true);
    $html .= getCssExample();
    return get_popup_html('column', $html);
}
function get_row_setting_html(){
    $html = get_textbox_html('Row name', 'lw-name', true);
    $html .= get_checkbox_html('Display name', 'lw-display-name', true);
    $html .= get_textbox_html('CSS class', 'lw-css-class', true);  
    $html .= getClassExample();
    $html .= get_textbox_html('Background image url', 'lw-background-image-url', true);
    $html .= get_textbox_html('Background color', 'lw-background-color', true);
    $html .= get_textarea_html_simple('Style css', 'lw-style-css', true);
    $html .= getCssExample();
    $html .= get_select_html('Full width', 'lw-full-width', get_width_arr(), true);  
    return get_popup_html('row', $html);
}
function get_post_type_arr(){
    $post_types = array();
    array_push($post_types, array(
        'text' => 'Category',
        'value' => 'category'
    ));
    array_push($post_types, array(
        'text' => 'Tag',
        'value' => 'tag'
    ));
    array_push($post_types, array(
        'text' => 'Search',
        'value' => 'search'
    ));
    array_push($post_types, array(
        'text' => 'Related posts',
        'value' => 'related_posts'
    ));
    return $post_types;
}
function get_width_arr(){    
    $items = array();
    array_push($items, array(
        'text' => 'Padding',
        'value' => 'padding'
    ));
    array_push($items, array(
        'text' => 'Full',
        'value' => 'full'
    ));
    array_push($items, array(
        'text' => 'Full + Padding',
        'value' => 'full+padding'
    ));
    return $items;
}
function get_thumbnail_size_arr(){
    $image_sizes = array();
    array_push($image_sizes, array(
        'text' => 'full',
        'value' => 'full'
    ));
    array_push($image_sizes, array(
        'text' => 'medium',
        'value' => 'medium'
    ));
    array_push($image_sizes, array(
        'text' => 'thumbnail',
        'value' => 'thumbnail'
    ));
    array_push($image_sizes, array(
        'text' => 'lw_slide_image_1366x(***)',
        'value' => 'lw_slide_image_1366x(***)'
    ));
    array_push($image_sizes, array(
        'text' => 'lw_featured_image_600x600',
        'value' => 'lw_featured_image_600x600'
    ));
    array_push($image_sizes, array(
        'text' => 'lw_featured_image_400x400',
        'value' => 'lw_featured_image_400x400'
    ));
    array_push($image_sizes, array(
        'text' => 'lw_featured_image_600x450',
        'value' => 'lw_featured_image_600x450'
    ));
    array_push($image_sizes, array(
        'text' => 'lw_featured_image_400x300',
        'value' => 'lw_featured_image_400x300'
    ));
    return $image_sizes;
}
function getClassExample(){
    return '<div class="field box">
    <div class="title field-title"></div>
    <div class="body field-body">
    <ul>
        <li>Margin: mt/mb/ml/mr + [-] + 0/1/2/3/4/5//auto</li>
        <li>Padding: pt/pb/pl/pr + [-] + 0/1/2/3/4/5//auto</li>
    </ul>
    </div>
</div>';
}
function getCssExample(){
    return '<div class="field box">
    <div class="title field-title"></div>
    <div class="body field-body">
    <ul>
        <li>background: bg-color bg-image position/bg-size bg-repeat bg-origin bg-clip bg-attachment initial|inherit;</li>
    </ul>
    </div>
</div>';
}
?>