<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_breakcrumb');

class lw_breakcrumb{
    public function form(){ 
        require_once(dirname(__FILE__).'/../../fields.php');

        $fields_html ='';  
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Breakcrumb', 'lw-breakcrumb', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){         
        echo '<ul>';
        if (!is_home()) {
            echo '<li><a href="';
            echo get_option('home');
            echo '">';
            echo 'Home';
            echo "</a></li>";
            if (is_category()){
                echo '<li>';
                echo single_cat_title();
                echo ' </li>';
            } if(is_single()) {
                echo '<li>';
                the_category(' </li><li> '); 
                echo "</li><li>";
                the_title();
                echo '</li>'; 
            } elseif (is_page()) {
                    echo '<li>';
                    echo the_title();
                    echo '</li>';
            }
        }
        elseif (is_tag()) {single_tag_title();}
        elseif (is_day()) {echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';}
        elseif (is_month()) {echo"<li>Archive for "; the_time('F, Y'); echo'</li>';}
        elseif (is_year()) {echo"<li>Archive for "; the_time('Y'); echo'</li>';}
        elseif (is_author()) {echo"<li>Author Archive"; echo'</li>';}
        elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'</li>';}
        elseif (is_search()) {echo"<li>Search Results"; echo'</li>';}
        echo '</ul>';
    }
} 

?>
