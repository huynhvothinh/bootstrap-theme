<?php
// 
add_action("admin_menu", "lw_add_theme_menu_item");
function lw_add_theme_menu_item(){
    add_menu_page("LW Setting", "LW Setting", "manage_options", "lw-setting", "lw_theme_settings_page", null, null);
}
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

// 
add_action("admin_init", "lw_display_theme_panel_fields");
function lw_display_theme_panel_fields(){
	add_settings_section("section", "All Settings", null, "theme-options");	
	add_settings_field("search_template", "Template settings", "display_lw_settings", "theme-options", "section");
    register_setting("section", "lw_settings"); 
}
function display_lw_settings(){
    $value = get_option('lw_settings');   
    ?>
    <div class="lw-theme-setting">
        <textarea name="lw_settings" id="lw_settings" style="display:none;"><?php echo $value;?></textarea>
        <table>
            <tbody>
                <?php 
                // $lw_json_settings = json_decode($value);

                // templates
                $template_arr = array();
                $posts = get_posts( 
                    array(
                        'post_type' => 'lw-template',
                        'posts_per_page'   => 500,
                        'orderby' => 'title',
                        'order' => 'ASC',
                    )
                );  
                
                foreach($posts as $post){ 
                    $template = array();
                    $template['id'] = $post->ID;
                    $template['title'] = $post->post_title; 
                    $template['name'] = $post->post_name; 
                    array_push($template_arr, $template);
                }
                
                // categories
                $categories = get_categories( array(
                    'orderby' => 'name',
                    'order'   => 'ASC'
                ) );  

                ?> 

                <tr>
                    <td><h3>Static pages</h3></td> 
                </tr>            

                <tr class="template-search page-template">
                    <td>Search page</td>
                    <td><?php dropdown_template($template_arr, 'template-search', '');?></td>
                </tr>
                <tr class="template-tag tag-template">
                    <td>Tag page</td>
                    <td><?php dropdown_template($template_arr, 'template-tag', '');?></td>
                </tr>
                <tr class="template-single-default page-template">
                    <td>Post page default</td>
                    <td><?php dropdown_template($template_arr, 'template-single-default', '');?></td>
                </tr>
                <tr class="template-category-default page-template">
                    <td>Category page default</td>
                    <td><?php dropdown_template($template_arr, 'template-category-default', '');?></td>
                </tr>

                <tr>
                    <td><h3><a href="#" class="lw-setting-categories">Categories >> </a></h3></td> 
                </tr>     

                <?php           
                foreach( $categories as $category ) {
                    ?>

                    <tr class="template-category" data-id="<?php echo $category->term_id; ?>"  data-name="<?php echo $category->name;?>">
                        <td><?php echo $category->name ?></td>
                        <td><?php dropdown_template($template_arr, 'template-category', '', '- User default -');?></td>
                    </tr>
                    <?php
                } 
                ?>
                
                <tr>
                    <td><h3><a href="#" class="lw-setting-posts">Post of category >> </a></h3></td> 
                </tr>     

                <?php           
                foreach( $categories as $category ) {
                    ?>
                    <tr class="template-category-single" data-id="<?php echo $category->term_id; ?>" data-name="<?php echo $category->name;?>">
                        <td>Post of [<?php echo $category->name ?>]</td>
                        <td><?php dropdown_template($template_arr, 'template-category-single', '', '- User default -');?></td>
                    </tr>
                    <?php
                } 
                ?>
            </tbody>
        </table>
        <script>
            jQuery(document).ready(function(){
                jQuery('a.lw-setting-categories').click(function(e){
                    e.preventDefault();
                    jQuery('.template-category').toggleClass('active');
                });
                jQuery('a.lw-setting-posts').click(function(e){
                    e.preventDefault();
                    jQuery('.template-category-single').toggleClass('active');
                });
            });
        </script>
    </div>
    <?php
}
function dropdown_template($template_arr, $class_key, $selected_value, $select_title='- Select template - '){
    ?>
    <select class="<?php echo $class_key;?> dropdown-template">
        <option value=""><?php echo $select_title;?></option>
        <?php foreach($template_arr as $item){
            $selected = $selected_value == $item['id'] ? 'selected' : ''; 
        ?>
            <option value="<?php echo $item['id'];?>" <?php echo $selected;?> 
                data-name="<?php echo $item['name'];?>" ><?php echo $item['title'];?></option>
        <?php  } // end for  ?>
    </select>
    <?php
}
?>