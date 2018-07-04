<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_post_list');

class lw_post_list{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');
        
        $items = array();
        $categories = get_categories(array( 
            'hide_empty'          => 0,
            'child_of'            => 0,
            'current_category'    => 0,
            'depth'               => 0,
            'hierarchical'        => true,
            'order'               => 'ASC',
            'orderby'             => 'name',
        )); 
        foreach( $categories as $category ) {
            $item = array();
            $item['text'] = $category->name;
            $item['value'] = $category->term_id;
            array_push($items, $item);
        }

        $fields_html = '';
        $fields_html .= get_select_html('Category', 'lw-post-category', $items);
        $fields_html .= get_textbox_html('Post total', 'lw-post-total');
        $fields_html .= get_textbox_html('Post CSS class', 'lw-post-css-class');
        $fields_html .= '<hr>';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Post list', 'lw-post-list', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){
        $post_category = '';
        $post_total = 12;
        $post_css_class = '';
        if(is_array($arr)){ 
            if(isset($arr['lw-post-category'])){
                $post_category = $arr['lw-post-category'];   
            }          
            if(isset($arr['lw-post-total'])){
                if(is_int($arr['lw-post-total'])){
                    $post_total = $arr['lw-post-total'];
                }
            }      
            if(isset($arr['lw-post-css-class'])){ 
                $post_css_class = $arr['lw-post-css-class']; 
            }
        }
        
        // show slider
        $posts = new WP_Query( 
            array( 
                'post_type' => 'post',
                'posts_per_page'   => $post_total,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => $post_category,
                        'include_children' => true
                    )
                )
            )
        ); 

        if ( $posts->have_posts() ){
            global $post;
            while ( $posts->have_posts() ) : $posts->the_post(); 
            ?>
                <div class="lw-post-item <?php echo $post_css_class;?>">
                    <div class="lw-post-thumbnail"><?php the_post_thumbnail( $post->ID, 'thumbnail');?></div>
                    <h5 class="lw-post-title"><?php the_title();?></h5>
                    <div class="lw-post-excerpt"><?php the_excerpt($post->ID);?></div>
                </div>
            <?php
            endwhile;
        }
    }
}
?>
