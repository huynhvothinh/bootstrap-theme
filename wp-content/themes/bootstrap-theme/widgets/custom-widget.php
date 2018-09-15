<?php 
// Register and load the widget
function lw_load_widget() {
    register_widget( 'lw_widget' );
}
add_action( 'widgets_init', 'lw_load_widget' );
 
// Creating the widget 
class lw_widget extends WP_Widget {
 
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'lw_widget', 
        
        // Widget name will appear in UI
        __('LW Custom Widget', 'lw_custom_widget'), 
        
        // Widget description
        array( 'description' => __( 'Add custom option in a widget', 'lw_custom_widget' ), ) 
        );
    }
 
    // Creating widget front-end    
    public function widget( $args, $instance ) {
        $lw_widgets_json = json_decode($instance['lw_widgets_json']);

        global $lw_widget_arr;

        $dirs = array_filter(glob(dirname(__FILE__).'/core/*'), 'is_dir');
        foreach($dirs as $dir){ 
            require_once $dir.'/widget.php';
        }  
        //
        $dirs = array_filter(glob(dirname(__FILE__).'/custom/*'), 'is_dir');
        foreach($dirs as $dir){ 
            require_once $dir.'/widget.php';
        }   

        // rows 
        foreach($lw_widgets_json->row_arr as $row){
            $this->get_row($row);
        }
    }

    // Creating widget front-end    
    public function widget_post($postID, $key='lw_widgets_json') {
        $meta = get_post_meta($postID, $key);

        if($meta){             
            $lw_widgets_json = json_decode($meta[0]); 

            if(is_object ($lw_widgets_json)){
                global $lw_widget_arr;

                $dirs = array_filter(glob(dirname(__FILE__).'/core/*'), 'is_dir');
                foreach($dirs as $dir){ 
                    $widget_file = $dir.'/widget.php';
                    if(file_exists($widget_file)){
                        require_once $widget_file;
                    }
                }  

                // rows 
                if(property_exists($lw_widgets_json, 'row_arr')){
                    foreach($lw_widgets_json->row_arr as $row){
                        $this->get_row($row);
                    }
                }
            }
        }
    }  
         
    // Widget Backend 
    public function form( $instance ) {
        $id = '1';
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New options', 'lw_custom_widget' );
        }

        if ( isset( $instance[ 'lw_widgets_json' ] ) ) {
            $lw_widgets_json = $instance[ 'lw_widgets_json' ];
        }
        else {
            $lw_widgets_json = '{}';
        }

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
            <input class="widefat lw-widget-title" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p> 
            <div class="lw-buttons">
                <input type="button" class="btn-show-settings button button-primary" data-lw-id="<?php echo $id;?>" value="Settings">
                <div class="lw_widgets_json" data-lw-id="<?php echo $id;?>">
                    <textarea style="display:none;" id="<?php echo $this->get_field_id( 'lw_widgets_json' ); ?>" name="<?php echo $this->get_field_name( 'lw_widgets_json' ); ?>"><?php echo $lw_widgets_json;?></textarea>
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

                        var widget = jQuery(this).closest('.widget');
                        var id = jQuery(widget).attr('id');
                        jQuery(widget).attr('data-lw-id', id);
                        jQuery(widget).find('[data-lw-id]').attr('data-lw-id', id); 

                        // // remove editor
                        // jQuery(widget).find('#wp-lw-editor-wrap').remove();

                        // reset first click
                        jQuery(widget).find('input[type="submit"]').click(function(){
                            jQuery(this).closest('.widget').find('.btn-show-settings').removeClass('first-clicked');
                        });

                        // init
                        widget_init(id);

                        // display popup
                        jQuery('.settings.lw-popup[data-lw-id="'+id+'"]').toggleClass('active');

                        // remove unused editor of wordpress
                        var count = jQuery('.lw-editor.lw-popup').length;
                        for(var i=count-1; i > 0; i--){
                            jQuery('.lw-editor.lw-popup')[i].remove();
                        }
                    });   
                });
            </script>
            <?php
                require_once(dirname(__FILE__).'/custom-html.php');
                load_custom_html($id); 
            ?>
        </p>
        <?php 
    }
     
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        // $instance['lw_widgets_json'] = ( ! empty( $new_instance['lw_widgets_json'] ) ) ? strip_tags( $new_instance['lw_widgets_json'] ) : '';
        $instance['lw_widgets_json'] = $new_instance['lw_widgets_json'];
        return $instance;
    }

    function get_row($row){  
        $full_width_class = array();
        array_push($full_width_class, 'container');
        array_push($full_width_class, '');
        if(property_exists($row, 'full_width')) {
            if($row->full_width){ 
                if($row->full_width == 'full'){
                    $full_width_class[0] = 'container-fruit';
                }else if($row->full_width == 'padding'){
                    $full_width_class[0] = 'container';
                }else if($row->full_width == 'full+padding'){
                    $full_width_class[0] = 'container-fruit';
                    $full_width_class[1] = 'container';
                } 
            } 
        } 
        $styles = array();
        if(property_exists($row, 'background_color') && $row->background_color){
            $styles['background_color_style'] =  'background-color:'.$row->background_color ;
        }
        if(property_exists($row, 'background_image_url') && $row->background_image_url) {
            $styles['background_image_style'] =  'background-image:url(\''.$row->background_image_url.'\');background-position: center;';
        }
        $styles_string = 'style="'.implode(';', $styles).'"';        

        ?>
        <div class="<?php echo $full_width_class[0] ;?> <?php echo $row->css_class;?>" <?php echo $styles_string;?>>
            <?php echo $full_width_class[1] ? '<div class="'.$full_width_class[1].'">' : '';?>
                <div class="row">
                    <?php if($row->display_name){ ?>
                    <h2 class="row-title"><?php echo $row->name;?></h2>
                    <?php } // end if?>

                    <?php             
                        foreach($row->column_arr as $column){
                            $this->get_column($column);
                        } // end for
                    ?>
                </div>
            <?php echo $full_width_class[1] ? '</div>' : '';?>
        </div>
        <?php
    }
    function get_column($column){ 
        ?>
        <div class="col-md-<?php echo $column->size;?> <?php echo $column->css_class;?>">
            <?php if($column->display_name){ ?>
            <h3 class="column-title"><?php echo $column->name;?></h3>
            <?php } // end if?>

            <?php             
                foreach($column->item_arr as $item){
                    $this->get_item($item);
                } // end for
            ?>
        </div>
        <?php
    }
    function get_item($item){        
        ?>
        <div class="item <?php echo $item->css_class;?> <?php echo $item->widget_name;?>">
            <?php if($item->display_name){ ?>
            <h4 class="item-title"><?php echo $item->name;?></h4>
            <?php } // end if?>

            <?php      
                $arr = [];       
                foreach($item->field_arr as $field){
                    $arr[$field->field] = $field->value;
                } // end for

                $widget_name = $item->widget_name;
                $widget_name = str_replace('-', '_', $widget_name);
                if(class_exists($widget_name)){
                    $obj = new $widget_name;
                    $obj->widget($arr);
                }
            ?>
        </div>
        <?php
    }
} // end class