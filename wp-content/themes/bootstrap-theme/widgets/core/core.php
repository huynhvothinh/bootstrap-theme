<?php
$content = '';
$dirs = array_filter(glob(dirname(__FILE__).'/*'), 'is_dir');
foreach($dirs as $dir){ 
    $dir_name = basename($dir);
    $css_file = $dir_name.'/'.$dir_name.'.css';
    $content = $content.'@import "'.$css_file.'";';
    $content = $content."\n";
}  
file_put_contents('core.css', $content,true);
?>