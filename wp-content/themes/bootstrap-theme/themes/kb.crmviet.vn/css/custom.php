<?php
$content = '';
$files = array_filter(glob(dirname(__FILE__).'/custom/*.css'), 'is_file');
foreach($files as $file){ 
    $file_name = basename($file);
    $css_file = 'custom/'.$file_name;
    $content = $content.'@import "'.$css_file.'";';
    $content = $content."\n";
}  
file_put_contents('custom.css', $content, true);
?>