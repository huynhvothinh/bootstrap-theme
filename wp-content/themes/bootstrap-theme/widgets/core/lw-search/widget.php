<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_search');

class lw_search{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');
        $fields_html ='';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Search', 'lw-search', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){
        $s = isset($_GET['s']) ? $_GET['s'] : '';
        ?>
        <form action="/"> 
            <div class="input-group mb-3">
                <input type="text" name="s" id="s"  class="form-control" 
                    placeholder="<?php _e('Search', 'lw'); ?>" value="<?php echo $s;?>">
                <div class="input-group-append">
                    <button class="btn btn-default" type="submit" ><?php _e('Search', 'lw'); ?></button> 
                </div>
            </div> 
        </form>
        <?php
    }
}

?>
