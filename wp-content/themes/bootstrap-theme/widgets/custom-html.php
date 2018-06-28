<?php
function load_custom_html( $id ) { 
?>
    <div class="settings lw-popup" data-lw-id="<?php echo $id; ?>">
        <div class="lw-popup-content">
            <div class="lw-popup-header settings-header"><a class="close" data-lw-id="<?php echo $id; ?>" href="#">Close</a></div>
            <div class="lw-buttons">
                <input type="button" class="btn-add-row button button-primary" data-lw-id="<?php echo $id; ?>" value="Add Row">
            </div>
            <div class="lw-widget-container" data-lw-id="<?php echo $id; ?>"></div>
            <div class="lw-widget-items lw-popup" data-lw-id="<?php echo $id; ?>">
                <div class="lw-popup-content">
                    <div class="lw-popup-header lw-widget-items-header"><a class="close" href="#">Close</a></div>
                    <div class="lw-popup-body">
                        <?php
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

                            foreach($lw_widget_arr as $widget_name){
                                if (class_exists($widget_name)) {
                                    $obj = new $widget_name;
                                    $obj->form();
                                }
                            }
                        ?>
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
    </div>
<?php
}
?>