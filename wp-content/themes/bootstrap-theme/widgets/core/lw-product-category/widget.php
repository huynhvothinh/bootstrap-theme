<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_product_category');

class lw_product_category{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');
        $fields_html ='';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Product category', 'lw-product-category', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){
        ?>
        <div class="lw-product-category"> 
            <?php 
            include_once(dirname(__FILE__).'/../../../woocommerce/archive-product-woo.php') ; 
            ?>
        </div>
        <?php
    }
}

?>
