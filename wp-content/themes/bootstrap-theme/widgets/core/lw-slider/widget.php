<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_slider');

class lw_slider{
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

        $fields_html = '';
        $fields_html .= get_select_html('Slider category', 'lw-slider', $items);
        $fields_html .= '<hr>';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Slider', 'lw-slider', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){
        $slider_category_slug = '';
        if(is_array($arr)){
            foreach($arr as $field){
                if($field->field == 'lw-slider'){
                    $slider_category_slug = $field->value;
                }
            }
        }
        
        // show slider
        $posts = get_posts( 
            array(
                'post_type' => 'lw-slider',
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
        if ( $posts ){
            for($i=0; $i<count($posts); $i++){
                $url =  get_the_post_thumbnail_url( $posts[$i]->ID, 'full');	
                $active = ($i === 0 ? 'active' : '');
                $content = $content .
                '<div class="carousel-item '.$active.'">'
                    .'<img src="'.$url.'">'
                .'</div>';			
            } 
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
