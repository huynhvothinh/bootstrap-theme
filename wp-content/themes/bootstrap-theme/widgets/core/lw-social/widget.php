<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_social'); 

class lw_social{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');
        $fields_html ='';
        for($i=0; $i<5; $i++){
            $fields_html .= '<h3>Social '.($i+1).'</h3>';
            $fields_html .= get_textbox_html('Social logo', 'lw-social-image-'.$i); 
            $fields_html .= get_textbox_html('Soical hyperlink', 'lw-social-hyperlink-'.$i); 
        }
        $fields_html .= '<hr>';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Social buttons', 'lw-social', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){  
        if(is_array($arr)){
    ?>
        <div class="lw-social">
    <?php
            for($i=0; $i<5; $i++){ 
                $link = $arr['lw-social-hyperlink-'.$i];
                $image = $arr['lw-social-image-'.$i];
                if($link && $image){
                    $actual_link  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                    $link = str_replace('{{url}}', $actual_link, $link);
                ?>
                    <div class="lw-social-item"> 
                        <a href="<?php echo $link;?>" target="_blank" class="lw-social-hyperlink">
                            <img src="<?php echo $image;?>" class="lw-social-image"> 
                        </a> 
                    </div> 
                <?php
                } // end if
            } // end for
        } // end if 
    ?>     
        </div>   
    <?php        
    }
}

?>
