<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_post_list');

class lw_post_list{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');
        
        $items = array();
        array_push($items, array(
            'text' => '- All -',
            'value' => ''
        ));
        array_push($items, array(
            'text' => '- Current category -',
            'value' => 'lw_current_category'
        ));
        array_push($items, array(
            'text' => '- Current tag -',
            'value' => 'lw_current_tag'
        ));
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
            $item['text'] = 'Cat - '.$category->name;
            $item['value'] = $category->term_id;
            array_push($items, $item);
        }
        
        $image_sizes = get_thumbnail_size_arr();
        $post_type = get_post_type_arr();

        $fields_html = '';
        $fields_html .= get_select_html('Post type', 'lw-post-type', $post_type);
        $fields_html .= get_select_html('Category/Tag', 'lw-post-category', $items);
        $fields_html .= get_textbox_html('Post per page (not for search)', 'lw-post-total');
        $fields_html .= get_select_html('Image size', 'lw-image-size', $image_sizes);
        $fields_html .= get_textbox_html('Post CSS class', 'lw-post-css-class');
        $fields_html .= '<hr>';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Post list', 'lw-post-list', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){
        $post_tag_category = '';
        $post_total = 12;
        $post_css_class = '';
        $image_size = 'full';
        $post_type = '';
        if(is_array($arr)){ 
            if(isset($arr['lw-post-category'])){
                $post_tag_category = $arr['lw-post-category'];   
                if($post_tag_category == 'lw_current_category' || $post_tag_category == 'lw_current_tag'){                    
                    $cat_obj = get_queried_object();
                    $post_tag_category = $cat_obj->term_id;
                }
            }          
            if(isset($arr['lw-post-total'])){ 
                $post_total = $arr['lw-post-total']; 
            }      
            if(isset($arr['lw-post-css-class'])){ 
                $post_css_class = $arr['lw-post-css-class']; 
            }
            if(isset($arr['lw-image-size'])){
                $image_size = $arr['lw-image-size']; 
            }
            if(isset($arr['lw-post-type'])){
                $post_type = $arr['lw-post-type']; 
            }
        }

        if($post_total > 24){
            $post_total = 24;
        }
        
        // show slider 
        $query = array();
        if($post_type == 'search'){
            global $query_string;
            wp_parse_str( $query_string, $query ); 

            // get default value
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $post_total = get_option('posts_per_page');;

            $query['post_type'] = 'post';
            $query['posts_per_page'] = $post_total; 
            $query['paged'] = $paged; 
            if($post_tag_category){
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => $post_tag_category,
                        'include_children' => true
                    )
                );
            }
        }else if($post_type == 'category'){
            $query = array( 
                'post_type' => 'post',
                'posts_per_page'   => $post_total
            );
            if($post_tag_category){
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => $post_tag_category,
                        'include_children' => true
                    )
                );
            }
        }else if($post_type == 'tag'){
            $query = array( 
                'post_type' => 'post',
                'posts_per_page'   => $post_total
            );
            if($post_tag_category){
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'post_tag',
                        'field' => 'term_id',
                        'terms' => $post_tag_category
                    )
                );
            }
        }else if($post_type == 'related_posts'){ 

        }
        
        $posts = new WP_Query( $query);         
        
        if($post_type == 'search'){
            $s = isset($_GET['s']) ? $_GET['s'] : '';
        ?>
            <div class="search-box">
                <form action="/"> 
                    <div class="input-group mb-3">
                        <input type="text" name="s" id="s"  class="form-control" 
                            placeholder="<?php _e('Search', 'lw'); ?>" value="<?php echo $s;?>">
                        <div class="input-group-append">
                            <button class="btn btn-default" type="submit" ><?php _e('Search', 'lw'); ?></button> 
                        </div>
                    </div> 
                </form>
            </div>
        <?php
        } // end if for search box

        if ( $posts->have_posts() ){
        ?>
            <div class="row">
            <?php
                global $post;
                while ( $posts->have_posts() ) : $posts->the_post(); 
                ?>
                    <div class="lw-post-item <?php echo $post_css_class;?>">
                        <div class="lw-post-thumbnail">
                            <?php echo get_the_post_thumbnail( $post->ID, $image_size);?>
                            <div class="lw-image-layer"></div>
                        </div>
                        <div class="lw-post-title">
                            <h5 class="lw-title">
                                <a href="<?php echo get_post_permalink();?>"><?php the_title();?></a>
                            </h5>
                        </div>
                        <div class="lw-post-excerpt"><?php the_excerpt($post->ID);?></div>
                    </div>
                <?php
                endwhile; // end while
            ?>
            </div>
            <?php
        
            if($post_type == 'search'){  
            ?>
                <div class="paging"> 
                    <?php lw_get_paging($posts);?>
                </div>
            <?php
            } // end if for paging
        } // end if
    }
}

function lw_get_paging($custom_query = null) { 
    $big = 999999999;
    $total = isset($custom_query->max_num_pages)?$custom_query->max_num_pages:'';
    if($total > 1){
    
        $html = '<ul class="pagination justify-content-center">';
        $html .= paginate_links( array(
           'base'        => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
           'format'   => '?paged=%#%',
           'current'  => max( 1, get_query_var('paged') ),
           'total'    => $total,
           'mid_size' => '5',
           'prev_text'    => __('Previous','lw'),
           'next_text'    => __('Next','lw'),
        ) );
        $html .= '</ul>';

        $html = str_replace('<a class=\'page-numbers\'',
            '<li class="page-item"><a class="page-link"',$html);
        $html = str_replace('<a class="prev page-numbers"',
            '<li class="page-item"><a class="page-link"',$html);
        $html = str_replace('<a class="next page-numbers"',
            '<li class="page-item"><a class="page-link"',$html);
        $html = str_replace('</a>','</a></li>',$html);

        $html = str_replace('<span aria-current=\'page\' class=\'page-numbers current\'>',
            '<li class="page-item active"><a class="page-link" href="#">',$html);
        $html = str_replace('</span>','</a></li>',$html);

        echo $html;
    } 
}
?>
