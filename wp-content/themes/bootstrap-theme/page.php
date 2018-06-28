<?php 
get_header();?>

<div class="container">
<?php
    global $post;
    $widget = new lw_widget();
    $widget->widget_post($post->ID);
?>
</div>

<?php
get_footer();?>