<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_product_list');

class lw_product_list{
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
        $categories = get_terms('product_cat', array( 
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
        $product_type = get_post_type_arr();

        $fields_html = '';
        $fields_html .= get_select_html('Post type', 'lw-product-type', $product_type);
        $fields_html .= get_select_html('Category/Tag', 'lw-product-category', $items);
        $fields_html .= get_checkbox_html('Show Paging', 'lw-show-paging');
        $fields_html .= get_checkbox_html('Carousel/Slider', 'lw-carousel');
        $fields_html .= get_textbox_html('Post per page (not for search)', 'lw-product-total');
        $fields_html .= get_select_html('Image size', 'lw-image-size', $image_sizes);
        $fields_html .= get_textbox_html('Post CSS class', 'lw-product-css-class', false, 'col-md-3 col-sm-6 col-12');
        $fields_html .= '<hr>';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Product list', 'lw-product-list', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){
        $listID = 'products-'.time();
        $product_tag_category = '';
        $product_total = 12;
        $product_css_class = '';
        $image_size = 'full';
        $product_type = '';
        $show_paging = false;
        $carousel = false;
        if(is_array($arr)){ 
            if(isset($arr['lw-product-category'])){
                $product_tag_category = $arr['lw-product-category'];   
                if($product_tag_category == 'lw_current_category' || $product_tag_category == 'lw_current_tag'){                    
                    $cat_obj = get_queried_object();
                    $product_tag_category = $cat_obj->term_id;
                }
            }          
            if(isset($arr['lw-product-total'])){ 
                $product_total = $arr['lw-product-total']; 
            }      
            if(isset($arr['lw-product-css-class'])){ 
                $product_css_class = $arr['lw-product-css-class']; 
            }
            if(isset($arr['lw-image-size'])){
                $image_size = $arr['lw-image-size']; 
            }
            if(isset($arr['lw-product-type'])){
                $product_type = $arr['lw-product-type']; 
            }
            if(isset($arr['lw-show-paging'])){
                $show_paging = $arr['lw-show-paging']; 
            }
            if(isset($arr['lw-carousel'])){
                $carousel = $arr['lw-carousel']; 
            }
        }

        if($product_total > 24){
            $product_total = 24;
        }
        
        // get default value
        $query = array();
        if($product_type == 'search'){
            global $query_string;
            wp_parse_str( $query_string, $query ); 

            $query['post_type'] = 'product';
            if($product_tag_category){
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $product_tag_category,
                        'include_children' => true
                    )
                );
            }
        }else if($product_type == 'category'){
            $query = array( 
                'post_type' => 'product',
                'posts_per_page'   => $product_total
            );
            if($product_tag_category){
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $product_tag_category,
                        'include_children' => true
                    )
                );
            }
        }else if($product_type == 'tag'){
            $query = array( 
                'post_type' => 'product',
                'posts_per_page'   => $product_total
            );
            if($product_tag_category){
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'product_tag',
                        'field' => 'term_id',
                        'terms' => $product_tag_category
                    )
                );
            }
        }else if($product_type == 'related_posts'){ 
            $arr = [];
            global $single;
            $postcat = get_the_category( $single->ID );
            if ( ! empty( $postcat ) ) {
                array_push($arr, $postcat[0]->cat_ID);
            }

            $query = array( 
                'post_type' => 'product',
                'posts_per_page'   => $product_total
            );
            $query['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $arr,
                    'include_children' => true
                )
            ); 
        }
        //
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        // $product_total = get_option('posts_per_page');
        $query['posts_per_page'] = $product_total; 
        $query['paged'] = $paged; 
        
        $posts = new WP_Query( $query);         
        
        if($product_type == 'search'){
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
            <div class="row <?php echo $listID;?> <?php echo $product_type;?> <?php echo ($carousel ? 'owl-carousel owl-theme' : '');?>">
            <?php
                global $post;
                while ( $posts->have_posts() ) : $posts->the_post(); global $product;
                ?>
                    <div class="lw-product-item item <?php echo ($carousel ? '' : $product_css_class);?>">
                        <div class="lw-product-thumbnail">
                            <a href="<?php echo get_post_permalink();?>">
                                <?php if (has_post_thumbnail( $post->ID )){
                                        echo get_the_post_thumbnail( $post->ID, $image_size);
                                    }else{
                                        echo '<img src="'.woocommerce_placeholder_img_src().'"/>'; 
                                    }
                                ?>
                                <div class="lw-image-layer"></div>
                            </a>
                        </div>
                        <div class="lw-product-date">
                            <i class="fa fa-calendar"></i>
                            <?php 
                                echo get_the_date('d-m-Y', $post->ID); 
                            ?>
                        </div>
                        <div class="lw-product-title">
                            <h5 class="lw-title">
                                <a href="<?php echo get_post_permalink();?>"><?php the_title();?></a>
                            </h5>
                        </div>
                        <div class="lw-product-price">
                            <?php 
                                woocommerce_show_product_sale_flash( $post, $product );
                                $price = $product->get_price_html(); 
                                $blank = $price ? '' : 'blank'; 
                                $price = $price ? $price : 'Liên hệ'; 
                            ?>
                            <span class="price <?php echo $blank; ?>">
                                <?php echo $price;?>
                            </span> 
                        </div>
                        <div class="lw-product-add-cart">
                            <?php woocommerce_template_loop_add_to_cart( $post, $product ); ?>
                        </div>
                    </div>
                <?php
                endwhile; // end while
            ?>
            </div>
            <?php
        
            if($show_paging){  
            ?>
                <div class="paging mt-3"> 
                    <?php lw_product_get_paging($posts);?>
                </div>
            <?php
            } // end if for paging

            if($carousel){
                ?>
                <script>
                    $('.owl-carousel.<?php echo $listID;?>').owlCarousel({
                        loop:false,
                        nav:true,
                        dots: true,
                        margin:10,
                        responsiveClass:true,
                        responsive:{
                            0:{
                                items:2, 
                                nav:true,
                            },
                            600:{
                                items:3,
                                nav:true,
                            },
                            1000:{
                                items:5,
                                nav:true,
                            }
                        }
                    })
                </script>
            <?php
            }
        } // end if
    }
}

function lw_product_get_paging($custom_query = null) { 
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
        $html = str_replace('<span class="page-numbers dots">',
            '<li class="page-item"><a class="page-link" href="#">',$html);
        $html = str_replace('</span>','</a></li>',$html);

        echo $html;
    } 
}
?>
