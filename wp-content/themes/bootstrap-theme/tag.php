<?php 
get_header();

$value = get_option('lw_settings');   
$lw_json_settings = json_decode($value);
$template_id = 0;
if(is_object($lw_json_settings)){
    $arr = (array)$lw_json_settings;
    if(isset($arr['template-tag'])){
        if($arr['template-tag']){
            $template_id = $arr['template-tag'];
        }
    }
}  
?>

<?php
if($template_id > 0){?>

    <?php
    $post = get_post($template_id);

    $sidebar_position = get_post_meta( $post->ID, 'lw_page_sidebar_position', true);
    if(!$sidebar_position) {
        $sidebar_position = 'hide';
    }
    // 
    $position_arr = get_sidebar_tag_arr($sidebar_position);
    $widget = new lw_widget();
    ?>

    <div class="container lw-widget-top">
        <?php $widget->widget_post($post->ID, 'lw_widgets_json_top');?>
    </div>

    <div class="container lw-widget-content <?php echo ($sidebar_position != 'hide' ? 'container' : '')?>">
    <?php
        // 
        echo $position_arr['first'];

        if($sidebar_position == 'left'){
            dynamic_sidebar('lw_sidebar');
        }else{        
            the_content();
            $widget->widget_post($post->ID);
        }
        
        //
        echo $position_arr['middle'];
        
        if($sidebar_position == 'right'){
            dynamic_sidebar('lw_sidebar');
        }else if($sidebar_position == 'left'){        
            the_content();
            $widget->widget_post($post->ID);
        }
        
        //
        echo $position_arr['end'];
    ?>
    </div>

    <div class="container lw-widget-bottom">
        <?php $widget->widget_post($post->ID, 'lw_widgets_json_bottom');?>
    </div>

<?php } // end if template_id ?>

<?php
get_footer();?> 