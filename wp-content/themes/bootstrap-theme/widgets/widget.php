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
    $meta_info = get_post_meta( $post->ID, '_meta_info', true) ? get_post_meta( $post->ID, '_meta_info', true) : 1; 
?>

    <div class="lw-buttons">
        <input type="button" class="btn-show-settings button button-primary" value="Settings">
    </div>
    <div class="settings lw-popup">
        <div class="lw-popup-content">
            <div class="lw-popup-header settings-header"><a class="close" href="#">Close</a></div>
            <div class="lw-buttons">
                <input type="button" class="btn-add-row button button-primary" value="Add Row">
            </div>
            <div class="lw-widget-container"></div>
            <div class="lw-widget-items lw-popup">
                <div class="lw-popup-content">
                    <div class="lw-popup-header lw-widget-items-header"><a class="close" href="#">Close</a></div>
                    <div class="lw-popup-body">
                        <?php
                            include dirname(__FILE__).'/core/editor/admin.php';
                            include dirname(__FILE__).'/core/textbox/admin.php';
                            include dirname(__FILE__).'/core/setting/admin.php';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="lw-editor lw-popup">
        <div class="lw-popup-content">
            <div class="lw-popup-header editor-header"><a class="close" href="#">Close</a></div>
            <div class="lw-popup-body">
                <?php
                    wp_editor( '', 'lw-editor' );
                ?>
            </div>
        </div>
    </div>
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../wp-content/themes/bootstrap-theme/assets-admin/css/styles.css">
    <script src="../wp-content/themes/bootstrap-theme/assets-admin/js/scripts.js"></script>

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
          update_post_meta( $post_id, '_meta_info', $_POST['_meta_info'] );
      }
  } 

}
?>