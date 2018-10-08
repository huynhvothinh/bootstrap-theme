<?php 
get_header();

// find category and parents, to map template
// priority:
// - current cat template
// - parent template
// - default template
$category = get_queried_object(); 
$cat_id_arr = array();
array_push($cat_id_arr, $category->term_id);
for($i=0; $i<5; $i++){
    if($category->parent){
        $category = get_category($category->parent);
        array_push($cat_id_arr, $category->term_id);
    }else{
        break;
    }
}

// template setting value
$value = get_option('lw_settings');   
$lw_json_settings = json_decode($value);
$template_id = 0;
if(is_object($lw_json_settings)){
    $arr = (array)$lw_json_settings;

    // set default, before find template
    if(isset($arr['template-category-default'])){
        if($arr['template-category-default']){
            $template_id = $arr['template-category-default'];
        }
    }

    // find template
    if(isset($arr['template-category-arr'])){
        if($arr['template-category-arr']){
            $template_arr = $arr['template-category-arr'];
            $found = false;
            foreach($cat_id_arr as $cat_id){ 
                foreach($template_arr as $temp){
                    $temp = (array)$temp; 
                    if($temp['category-id'] == $cat_id && $temp['template-id']){
                        $template_id = $temp['template-id'];
                        $found = true; 
                        break;
                    }
                }
                if($found){
                    break;
                }
            }
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

    <div class="lw-widget-top">
        <?php $widget->widget_post($post->ID, 'lw_widgets_json_top');?>
    </div>

    <div class="lw-widget-content <?php echo ($sidebar_position != 'hide' ? 'container' : '')?>">
    <?php
        // 
        echo $position_arr['first'];

        if($sidebar_position == 'left'){
            dynamic_sidebar('lw_sidebar');
        }else{        
            // the_content();
            $widget->widget_post($post->ID);
        }
        
        //
        echo $position_arr['middle'];
        
        if($sidebar_position == 'right'){
            dynamic_sidebar('lw_sidebar');
        }else if($sidebar_position == 'left'){        
            // the_content();
            $widget->widget_post($post->ID);
        }
        
        //
        echo $position_arr['end'];
    ?>
    </div>

    <div class="lw-widget-bottom">
        <?php $widget->widget_post($post->ID, 'lw_widgets_json_bottom');?>
    </div>

<?php } // end if template_id ?>

<?php
get_footer();?> 