<?php
/* Define the custom box */

// WP 3.0+
add_action( 'add_meta_boxes', 'post_options_widget' );

// backwards compatible
add_action( 'admin_init', 'post_options_widget', 1 );

/* Do something with the data entered */
add_action( 'save_post', 'save_post_options_widget' );

/**
 *  Adds a box to the main column on the Post edit screen
 * 
 */
function post_options_widget() {
    add_meta_box( 'post_options', __( 'Custom Widgets' ), 'post_options_code_widget', ['post', 'page'], 'normal', 'high' );
}

/**
 *  Prints the box content
 */
function post_options_code_widget( $post ) { 
    wp_nonce_field( plugin_basename( __FILE__ ), $post->post_type . '_noncename' );
    $lw_widgets_json = get_post_meta( $post->ID, 'lw_widgets_json', true) ? get_post_meta( $post->ID, 'lw_widgets_json', true) : 1; 
    $id = 'post_options_code_widget'; 
?>
    <div class="widget" data-lw-id="<?php echo $id;?>">
        <div class="lw-buttons">
            <input type="button" class="btn-show-settings button button-primary" data-lw-id="<?php echo $id;?>" value="Settings">
            <div class="lw_widgets_json" data-lw-id="<?php echo $id;?>">
                <textarea style="display:none;" id="lw_widgets_json" name="lw_widgets_json"><?php echo $lw_widgets_json;?></textarea>
            </div>
        </div>
        <script>
            jQuery(document).ready(function(){
                jQuery('.btn-show-settings').click(function(){
                    if(jQuery(this).hasClass('first-clicked')){
                        return;
                    }else{
                        jQuery(this).addClass('first-clicked');
                    }
                    var id = '<?php echo $id;?>';

                    // get value of json
                    jQuery('.close[data-lw-id="'+id+'"]').click(function(){ 
                        jQuery('.lw_widgets_json[data-lw-id="'+id+'"] textarea').val(JSON.stringify(getJson(id))); 
                    });

                    // init
                    widget_init(id);

                    // display popup
                    jQuery('.settings.lw-popup[data-lw-id="'+id+'"]').toggleClass('active');
                });
            });
        </script>
    <?php
        require_once(dirname(__FILE__).'/custom-html.php');
        load_custom_html($id); 
    ?>
    </div>
<?php
}

/** 
 * When the post is saved, saves our custom data 
 */
function save_post_options_widget( $post_id ) {
    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !wp_verify_nonce( @$_POST[$_POST['post_type'] . '_noncename'], plugin_basename( __FILE__ ) ) )
        return;

    // Check permissions
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;

    // OK, we're authenticated: we need to find and save the data
    if( 'post' == $_POST['post_type'] || 'page' == $_POST['post_type'] ) {
        if ( !current_user_can( 'edit_post', $post_id ) ) {
            return;
        } else {
            update_post_meta( $post_id, 'lw_widgets_json', $_POST['lw_widgets_json'] );
        }
    }
}
?>