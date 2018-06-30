<?php 
get_header();

$post = get_page_by_path( 'search', OBJECT, 'lw-template' );

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

<div class="container lw-widget-content">
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

    if($sidebar_position == 'left'){
        the_content();

        $widget = new lw_widget();
        $widget->widget_post($post->ID);
    }else{        
        dynamic_sidebar('lw_sidebar');
    }
    
    //
    echo $position_arr['end'];
?>
</div>

<div class="container lw-widget-bottom">
    <?php $widget->widget_post($post->ID, 'lw_widgets_json_bottom');?>
</div>

<?php
get_footer();?> 