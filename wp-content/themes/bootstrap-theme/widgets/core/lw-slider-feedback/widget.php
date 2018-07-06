<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_slider_feedback');

class lw_slider_feedback{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');
        
        $items = array();
        $terms = get_terms('lw-slider-category');
        foreach ( $terms as $term ) {
            $item = array();
            $item['text'] = $term->name;
            $item['value'] = $term->slug;
            array_push($items, $item);
        }

        $image_sizes = get_thumbnail_size_arr();

        $fields_html = '';
        $fields_html .= get_select_html('Slider category', 'lw-slider-feedback', $items);
        $fields_html .= get_select_html('Image size', 'lw-image-size', $image_sizes);
        $fields_html .= '<hr>';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Feedback Slider', 'lw-slider-feedback', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){
        $slider_category_slug = '';
        $image_size = 'full';
        if(is_array($arr)){ 
            if(isset($arr['lw-slider-feedback'])){
                $slider_category_slug = $arr['lw-slider-feedback']; 
            }
            if(isset($arr['lw-image-size'])){
                $image_size = $arr['lw-image-size']; 
            }
        }
        
        // show slider
        $posts = new WP_Query( 
            array(
                'post_type' => 'lw-slider',
                'posts_per_page'   => 500,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'lw-slider-category',
                        'field' => 'slug',
                        'terms' => $slider_category_slug,
                        'include_children' => true
                    )
                )
            )
        );

        $content = '';
        $url = '';
        $active = '';
        $slider_id = 'slider-'.$slider_category_slug;
        if ( $posts->have_posts() ){
            $index=0;
            global $post;
            while ( $posts->have_posts() ) : $posts->the_post(); 
                $active = '';
                if($index == 0){
                    $active = 'active';
                    $index++;
                } 
                $content = $content .
                '<div class="carousel-item '.$active.'">
                    <div class="row">
                        <div class="col-md-8 col-12 feedback-body">
                            <h5 class="feedback-title">'.get_the_title().'</h5>
                            <p class="feedback-content">'.get_the_content().'</p>
                        </div>
                        <div class="col-md-4 col-12 feedback-image">
                            <div class="image-wrapper">
                                '.get_the_post_thumbnail( $post->ID, $image_size).'
                            </div>
                        </div>
                    </div>
                </div>';			
            endwhile;
            wp_reset_postdata();
        } 
    ?>        
        <div id="<?php echo $slider_id;?>" class="carousel slide" data-ride="carousel"> 
            <div class="carousel-inner">
                <?php echo $content;?>
            </div>
            <a class="carousel-control-prev" href="#<?php echo $slider_id;?>" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#<?php echo $slider_id;?>" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
       </div>
    <?php
    }
}
?>
