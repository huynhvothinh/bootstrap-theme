<?php 
get_header();

global $post;
$sidebar_position = get_post_meta( $post->ID, 'lw_page_sidebar_position', true);
if(!$sidebar_position) {
    $sidebar_position = 'hide';
}
$position_arr = get_sidebar_tag_arr($sidebar_position);
?>

<div class="container">
<?php
    echo $position_arr['first'];

    if($sidebar_position == 'left'){
        dynamic_sidebar('lw_sidebar');
    }else{         
    }
    
    echo $position_arr['middle'];

    if($sidebar_position == 'left'){ 
    }else{        
        dynamic_sidebar('lw_sidebar');
    }
    
    echo $position_arr['end'];
?>
</div>

<?php
get_footer();?> 