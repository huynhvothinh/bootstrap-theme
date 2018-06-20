<?php
require_once(dirname(__FILE__).'/../../fields.php');

$setting_html = get_column_setting_html(); 
$setting_html .= get_row_setting_html(); 
echo $setting_html;
?>
