<?php 
get_header();

// find post categories
$cat_arr = get_the_category($post->ID); 
$cat_id_arr = array(); 
foreach($cat_arr as $cat){
    array_push($cat_id_arr, $cat->term_id);
}

// template setting value
$value = get_option('lw_settings');   
$lw_json_settings = json_decode($value);
$template_id = 0;
if(is_object($lw_json_settings)){
    $arr = (array)$lw_json_settings;

    // set default, before find template
    if(isset($arr['template-product-default'])){
        if($arr['template-product-default']){
            $template_id = $arr['template-product-default'];
        }
    }

    // // find template
    // if(isset($arr['template-category-single-arr'])){
    //     if($arr['template-category-single-arr']){
    //         $template_arr = $arr['template-category-single-arr'];
    //         $found = false;
    //         foreach($cat_id_arr as $cat_id){ 
    //             foreach($template_arr as $temp){
    //                 $temp = (array)$temp; 
    //                 if($temp['category-id'] == $cat_id && $temp['template-id']){
    //                     $template_id = $temp['template-id'];
    //                     $found = true; 
    //                     break;
    //                 }
    //             }
    //             if($found){
    //                 break;
    //             }
    //         }
    //     }
    // }
}  
?>

<?php
if($template_id > 0){?>

    <?php
    global $single;
    $single = $post;

    $sidebar_position = get_post_meta( $template_id, 'lw_page_sidebar_position', true);
    if(!$sidebar_position) {
        $sidebar_position = 'hide';
    }
    // 
    $position_arr = get_sidebar_tag_arr($sidebar_position);
    $widget = new lw_widget();
    ?>

    <div class="lw-widget-top">
        <?php $widget->widget_post($template_id, 'lw_widgets_json_top');?>
    </div>

    <div class="lw-widget-content <?php echo $sidebar_position != 'hide' ? 'container': ''; ?>">
    <?php
        // 
        echo $position_arr['first'];

        if($sidebar_position == 'left'){
            dynamic_sidebar('lw_sidebar');
        }else{        
            include_once(dirname(__FILE__).'/single-product-woo.php') ;  
            $widget->widget_post($template_id);
        }
        
        //
        echo $position_arr['middle'];
        
        if($sidebar_position == 'right'){
            dynamic_sidebar('lw_sidebar');
        }else if($sidebar_position == 'left'){ 
            include_once(dirname(__FILE__).'/single-product-woo.php') ;  
            $widget->widget_post($template_id);
        }
        
        //
        echo $position_arr['end'];
    ?>
    </div>

    <div class="lw-widget-bottom">
        <?php $widget->widget_post($template_id, 'lw_widgets_json_bottom');?>
    </div>

<?php } // end if template_id ?>

<?php
get_footer();?> 