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
    add_meta_box( 'post_options_all', __( 'LW Custom Widgets' ), 'post_options_all_widgets', ['page','lw-template'], 'normal', 'high' );
}

function post_options_all_widgets($post){
    $use_default = get_post_meta( $post->ID, 'lw_use_default', true);
    $checked = $use_default ? 'checked' : '';

    if(is_page()){
?>
    <h3><label for="lw_use_default">Use default template</label>
    <input type="checkbox" name="lw_use_default" id="lw_use_default" <?php echo $checked;?>></h3>
<?php 
    } // end is page?>
    <script>
        jQuery(document).ready(function(){
            jQuery('#lw_use_default').change(function(){
                if(jQuery(this).is(":checked")){
                    jQuery('#lw_setting_table').hide();
                }else{
                    jQuery('#lw_setting_table').show();
                }
            });
            jQuery('#lw_use_default').change();
        });
    </script>
    <table id="lw_setting_table" border="1" style="width:100%; max-width:600px;">
        <tbody>
            <tr>
                <td colspan="2"><h4>HEADER</h4></td>
            </tr>
            <tr>
                <td colspan="2">
                    <h4>WIDGET TOP</h4>
                    <?php post_options_code_widget_top($post);?>
                </td>
            </tr>
            <tr>
                <td>
                    <h4>POST/PAGE CONTENT</h4>
                    <hr>
                    <h4>WIDGET CONTENT</h4>
                    <?php post_options_code_widget($post);?>
                </td>
                <td>
                    <h4>SIDEBAR</h4>
                    <?php post_options_page_sidebar_position( $post );?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <h4>WIDGET BOTTOM</h4>
                    <?php post_options_code_widget_bottom($post);?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><h4>FOOTER</h4></td>
            </tr>
        </tbody>
    </table>
<?php
}

function post_options_code_widget_top( $post ) { 
    post_options_code_widget_base($post, 'top', true);
}
function post_options_code_widget_bottom( $post ) { 
    post_options_code_widget_base($post, 'bottom', false);
}
function post_options_code_widget( $post ) { 
    post_options_code_widget_base($post, '', false);
}
function post_options_code_widget_base( $post, $position = '', $add_editor=true) { 
    if($position){
        $position = '_'.$position;
    }
    
    wp_nonce_field( plugin_basename( __FILE__ ), $post->post_type . '_noncename' );
    $lw_widgets_json_string = 'lw_widgets_json'.$position;
    $lw_widgets_json = get_post_meta( $post->ID, $lw_widgets_json_string, true);
    if(!$lw_widgets_json){
        if($position){
            $lw_widgets_json = '{}';
        }else{
            $lw_widgets_json = '{"row_arr":[{"id":"1","type":"row","name":"","display_name":false,"css_class":"mt-3","full_width":"padding","background_image_url":"","background_color":"","column_arr":[{"id":"2","type":"column","name":"","display_name":false,"css_class":"","background_image_url":"","size":"12","item_arr":[{"id":"3","type":"item","name":"","display_name":false,"css_class":"","background_image_url":"","widget_name":"lw-page-title","field_arr":[]},{"id":"4","type":"item","name":"","display_name":false,"css_class":"","background_image_url":"","widget_name":"lw-post-content","field_arr":[{"field":"lw-content-format","value":"normal","type":"text"}]}]}]}]}';
        }
    }
    $id = 'post_options_code_widget'.$position; 
?>
    <div class="widget" data-lw-id="<?php echo $id;?>">
        <div class="lw-buttons">
            <input type="button" class="btn-show-settings button button-primary" data-lw-id="<?php echo $id;?>" value="Settings">            
            <div class="lw_widgets_json" data-lw-id="<?php echo $id;?>">
                <textarea style="display:none;" id="<?php echo $lw_widgets_json_string;?>" name="<?php echo $lw_widgets_json_string;?>"><?php echo $lw_widgets_json;?></textarea>
            </div>
        </div>
        <script>
            jQuery(document).ready(function(){
                jQuery('.btn-show-settings[data-lw-id="<?php echo $id;?>"]').click(function(){
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
        load_custom_html($id, $add_editor);  
    ?>
    </div>
<?php
}

function post_options_page_sidebar_position( $post ) { 
    wp_nonce_field( plugin_basename( __FILE__ ), $post->post_type . '_noncename' ); 
    $value = get_post_meta( $post->ID, 'lw_page_sidebar_position', true);
    if(!$value) {
        $value = 'hide';
    }

    $arr = [];
    array_push($arr, [ 'text' => 'No sidebar', 'value' => 'hide' ]);
    array_push($arr, [ 'text' => 'Left', 'value' => 'left' ]);
    array_push($arr, [ 'text' => 'Right', 'value' => 'right' ]);   
	?> 
        <select name="lw_page_sidebar_position" id="lw_page_sidebar_position">
            <?php foreach($arr as $item){
                $selected = $value == $item['value'] ? 'selected' : ''; 
            ?>
                <option value="<?php echo $item['value'];?>" <?php echo $selected;?> ><?php echo $item['text'];?></option>
            <?php  } // end for  ?>
        </select>
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
    if('page' == $_POST['post_type'] || 'lw-template' == $_POST['post_type']) { 
        if(isset($_POST['lw_widgets_json']))
            update_post_meta( $post_id, 'lw_widgets_json', $_POST['lw_widgets_json'] );              

        if(isset($_POST['lw_widgets_json_top']))
            update_post_meta( $post_id, 'lw_widgets_json_top', $_POST['lw_widgets_json_top'] );

        if(isset($_POST['lw_widgets_json_bottom']))
            update_post_meta( $post_id, 'lw_widgets_json_bottom', $_POST['lw_widgets_json_bottom'] ); 

        if(isset($_POST['lw_page_sidebar_position']))
            update_post_meta( $post_id, 'lw_page_sidebar_position', $_POST['lw_page_sidebar_position'] );
            
        if(isset($_POST['lw_use_default']))
            update_post_meta( $post_id, 'lw_use_default', $_POST['lw_use_default'] );
        else
            update_post_meta( $post_id, 'lw_use_default', false);
    }
}
?>