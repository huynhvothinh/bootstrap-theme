<?php
global $lw_widget_arr;
array_push($lw_widget_arr, 'lw_post_content');

class lw_post_content{
    public function form(){
        require_once(dirname(__FILE__).'/../../fields.php');

        $contents = array();        
        array_push($contents, array());
        array_push($contents, array());
        $contents[0]['text'] = 'Normal';
        $contents[0]['value'] = 'normal';
        $contents[1]['text'] = 'Quickview';
        $contents[1]['value'] = 'quickview';

        $fields_html ='';
        $fields_html .= get_select_html('Content format', 'lw-content-format', $contents);
        $fields_html .= '<hr>';
        $fields_html .= get_item_setting_html();
        $field_group_html = get_field_group_html('Post/Page content', 'lw-post-content', $fields_html);
        echo $field_group_html;
    }
    public function widget($arr){
        global $single; 

        $contentFormat = isset($arr['lw-content-format']) ? $arr['lw-content-format'] : '';

        if($contentFormat == 'quickview'){ ?>

        <div class="lw-post-content"> 
            <div class="row" >
                <div class="col-md-9 col-sm-8 col-12">
                    <div class="post-content">
                    <?php
                        if($single){
                            // echo '<h2 class="lw-page-title">'.$single->post_title.'</h2>';
                            echo $single->post_content;
                        }
                    ?> 
                    </div>
                </div>            
                <div class="col-md-3 col-sm-4 col-12">
                    <div class="quickview"></div>
                    <script>
                        jQuery(document).ready(function(){ 
                            if(jQuery('#wpadminbar').length >0){
                                jQuery('body').addClass('has-admin');
                            }
                            jQuery('body').addClass('quickviewbox');

                            var ul = jQuery('<ul></ul>');
                            var index = 1;
                            jQuery('.lw-post-content .post-content').find("h1, h2, h3, h4, h5, h6").each(function(){                            
                                var title = jQuery(this).text();
                                var id = title.split(' ').join('-');
                                id = id.split('.').join('-');
                                id = index+'-'+id.substring(0, 10);
                                jQuery(this).attr('id', id);
                                
                                var link = jQuery('<li><a href="#'+id+'">'+title+'</a></li>');
                                jQuery(ul).append(link);
                                
                                index++;
                            });
                            jQuery('.quickview').append(ul);

                            jQuery(".quickview a").click(function(){ 
                                jQuery('html, body').animate({
                                    scrollTop: jQuery(jQuery(this).attr('href')).offset().top - 100
                                }, 500);
                            });
                        })
                    </script>
                </div>
            </div>
        </div>

        <?php }else{ ?>

        <div class="lw-post-content">  
            <?php
                if($single){
                    echo $single->post_content;
                } // end if
            ?> 
        </div>

        <?php } // end if
    }
}

?>
