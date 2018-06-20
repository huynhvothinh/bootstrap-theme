<?php
require_once(dirname(__FILE__).'/../../fields.php');

$fields_html = '';
$fields_html .= get_textbox_html('Content', 'lw-textbox');
$fields_html .= '<hr>';
$fields_html .= get_item_setting_html();
$field_group_html = get_field_group_html('Textbox', 'lw-textbox', $fields_html);
echo $field_group_html;
?>
