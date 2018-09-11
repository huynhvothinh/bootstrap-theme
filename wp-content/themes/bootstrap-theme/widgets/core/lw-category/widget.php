<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_category');

class lw_category{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');

        $cat_arr = get_categories();        
        $items = array();  
        array_push($items, array());
        $items[0]['text'] = '- All categories';
        $items[0]['value'] = '0';
        if($cat_arr){
            for($i=0;$i<count($cat_arr);$i++){
                $item = [];
                $item['text']=$cat_arr[$i]->name;
                $item['value']=$cat_arr[$i]->term_id;
                array_push($items, $item);
            }
        }

        $fields_html ='';
        $fields_html .= get_select_html('Category of', 'lw-category-of', $items);
        $fields_html .= '<hr>';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Category', 'lw-category', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){
        $category_of = '0';
        if(isset($arr['lw-category-of'])){
            $category_of = $arr['lw-category-of'];
        }
        ?>
        <div class="lw-category"> 
            <?php  
            wp_list_categories(array(
                'child_of' => $category_of,
                'title_li' => '',
                'hierarchical' => true,
                'order' => 'ASC'
            ));
            ?> 
        </div>
        <?php
    }
}

?>
