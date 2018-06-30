<?php
function lw_theme_settings_page(){
?>
    <div class="wrap">
        <h1>LW Bootstrap Theme setting</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields("section");
                do_settings_sections("theme-options");      
                submit_button(); 
            ?>          
        </form>
    </div>
<?php
}

add_action("admin_menu", "lw_add_theme_menu_item");
function lw_add_theme_menu_item(){
    add_menu_page("LW Setting", "LW Setting", "manage_options", "lw-setting", "lw_theme_settings_page", null, null);
}


function display_search_element(){
    $arr = [];
    array_push($arr, [ 'text' => 'No sidebar', 'value' => 'hide' ]);
    array_push($arr, [ 'text' => 'Left', 'value' => 'left' ]);
    array_push($arr, [ 'text' => 'Right', 'value' => 'right' ]);  

    $value = get_option('search_sidebar');
	?> 
        <h5>Search sidebar</h5>
        <select name="search_sidebar" id="search_sidebar">
            <?php foreach($arr as $item){
                $selected = $value == $item['value'] ? 'selected' : ''; 
            ?>
                <option value="<?php echo $item['value'];?>" <?php echo $selected;?> ><?php echo $item['text'];?></option>
            <?php  } // end for  ?>
        </select>
    <?php
}
function display_single_element(){
    $arr = [];
    array_push($arr, [ 'text' => 'No sidebar', 'value' => 'hide' ]);
    array_push($arr, [ 'text' => 'Left', 'value' => 'left' ]);
    array_push($arr, [ 'text' => 'Right', 'value' => 'right' ]);  

    $value = get_option('single_sidebar');
	?> 
        <h5>Single sidebar</h5>
        <select name="single_sidebar" id="single_sidebar">
            <?php foreach($arr as $item){
                $selected = $value == $item['value'] ? 'selected' : ''; 
            ?>
                <option value="<?php echo $item['value'];?>" <?php echo $selected;?> ><?php echo $item['text'];?></option>
            <?php  } // end for  ?>
        </select>
    <?php
}
function lw_display_theme_panel_fields(){
	add_settings_section("section", "All Settings", null, "theme-options");
	
	add_settings_field("search_template", "Search Template", "display_search_element", "theme-options", "section");
    add_settings_field("single_template", "Single Template", "display_single_element", "theme-options", "section");

    register_setting("section", "search_sidebar"); 
    register_setting("section", "single_sidebar");
}

add_action("admin_init", "lw_display_theme_panel_fields");
?>