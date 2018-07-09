<?php 
get_header();

global $post;
global $single;
$single = $post; // backup current post to use in widget
   
// change template if set default, or use current page template
$use_default_template = get_post_meta( $post->ID, 'lw_use_default', true);
if($use_default_template){ 
    // template setting value
    $value = get_option('lw_settings');   
    $lw_json_settings = json_decode($value);
    $template_id = 0;
    if(is_object($lw_json_settings)){
        $arr = (array)$lw_json_settings;

        // set default, before find template
        if(isset($arr['template-page-default'])){
            if($arr['template-page-default']){
                $template_id = $arr['template-page-default'];
                $post = get_post($template_id);
            }
        }
    }
}

$sidebar_position = get_post_meta( $post->ID, 'lw_page_sidebar_position', true);
if(!$sidebar_position) {
    $sidebar_position = 'hide';
}
// 
$position_arr = get_sidebar_tag_arr($sidebar_position);
$widget = new lw_widget();
?>

<div class="lw-widget-top">
    <?php $widget->widget_post($post->ID, 'lw_widgets_json_top');?>
</div>

<div class="lw-widget-content">
    <?php
        // 
        echo $position_arr['first'];

        if($sidebar_position == 'left'){
            dynamic_sidebar('lw_sidebar');
        }else{        
            $widget->widget_post($post->ID);
        }
        
        //
        echo $position_arr['middle'];
        
        if($sidebar_position == 'right'){
            dynamic_sidebar('lw_sidebar');
        }else if($sidebar_position == 'left'){ 
            $widget->widget_post($post->ID);
        }
        
        //
        echo $position_arr['end'];
    ?>
</div>

<div class="lw-widget-bottom">
    <?php $widget->widget_post($post->ID, 'lw_widgets_json_bottom');?>
</div>

<?php
get_footer();?> 