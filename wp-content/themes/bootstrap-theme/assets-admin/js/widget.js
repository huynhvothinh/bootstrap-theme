var index = 0; 
var set_editor = false;

function widget_init(id){    
    var widget = jQuery('.widget[data-lw-id="'+id+'"]');

    // btn setting of widgets
    jQuery(widget).find('.btn-show-settings').click(function(){ 
        var id = jQuery(this).attr('data-lw-id');
        jQuery('.settings.lw-popup[data-lw-id="'+id+'"]').toggleClass('active');
    }); 
    // btn close setting
    jQuery(widget).find('.settings-header .close').click(function(e){
        e.preventDefault();
        jQuery(this).closest('.lw-popup').toggleClass('active');
    });
    // btn add row
    jQuery(widget).find('.btn-add-row').click(function(){ 
        var body_html = jQuery('.lw-widget-items .lw-row-setting').parent().html();
        var id = jQuery(this).attr('data-lw-id');
        jQuery('.lw-widget-container[data-lw-id="'+id+'"]').append(getRowHtml(body_html));
    });
    // 
    jQuery(widget).find('.lw-widget-container').click(function(e){ 
        setTimeout(function(){
            jQuery('.box').removeClass('moved');
        }, 2000)
    });
    // btn close box of all items
    jQuery(widget).find('.lw-widget-items-header .close').click(function(e){
        e.preventDefault();
        jQuery(this).closest('.lw-widget-items').toggleClass('active');        
    });
    // select an item
    jQuery(widget).find('.field-group-header').click(function(){ 
        var index = jQuery(this).closest('.lw-widget-items').attr('data-index');
        var body_html = jQuery(this).closest('.field-group').find('.field-group-body').html();
        var item_title = jQuery(this).closest('.field-group').find('.field-group-header').text();
        jQuery('.column[data-index="'+index+'"]').find('.column-body').append(getItemHtml(body_html, item_title));    
        //
        jQuery(this).closest('.lw-popup').toggleClass('active');         
    }); 
    // btn close default wordpress editor
    if(!set_editor){
        set_editor = true;
        jQuery('.lw-editor.lw-popup .close').click(function(){ 
            var index = jQuery('.lw-editor.lw-popup').attr('data-index');
            var item = jQuery('.item[data-index="'+index+'"]');
            var fieldKey = jQuery('.lw-editor.lw-popup').attr('data-field');
            jQuery('.lw-editor.lw-popup').toggleClass('active');
            jQuery(item).find('.field-value.textarea[field-key="'+fieldKey+'"]').val(tinymce.editors['lw-editor'].getContent());
            tinymce.editors['lw-editor'].setContent(''); 
            jQuery('.lw-editor.lw-popup').closest('.widget-inside').hide();
        });
    }
                            
    // get value of json
    jQuery('.close[data-lw-id="'+id+'"]').click(function(){ 
        var id = jQuery(this).attr('data-lw-id');
        jQuery('.lw_widgets_json[data-lw-id="'+id+'"] textarea').val(JSON.stringify(getJson(id)));
        jQuery(this).closest('.widget').find('.lw-widget-title').change();
    });

    // load widget by json
    load_widget(id); 
}

function getRowHtml(body_html){
    var row = jQuery('\
        <div class="row box" data-index="'+(++index)+'">\
            <div class="header row-header">\
                Row: <strong class="row-name"></strong>\
                / width: <strong class="row-width"></strong>\
                / css: <strong class="row-css"></strong>\
                <div class="right">\
                    <a href="#" class="btn btn-add btn-add-column" >Add Column</a>  \
                    <a href="#" class="btn btn-edit btn-edit-row" ><i class="fas fa-edit"></i></a>  \
                    <a href="#" class="btn btn-delete btn-delete-row" ><i class="fas fa-trash"></i></a>  \
                    <a href="#" class="btn btn-up btn-up-row" ><i class="fas fa-caret-square-up"></i></a>  \
                    <a href="#" class="btn btn-down btn-down-row" ><i class="fas fa-caret-square-down"></i></a>  \
                </div>\
            </div>\
            <div class="body row-body">'+body_html+'</div>\
        </div>');

    jQuery(row).find('.btn-add-column').click(function(e){  
        e.preventDefault();        
        var body_html = jQuery('.lw-widget-items .lw-column-setting').parent().html();
        jQuery(this).closest('.box').find('.row-body').append(getColumnHtml(body_html));
    });

    jQuery(row).find('.btn-edit-row').click(function(e){  
        e.preventDefault();         
        jQuery(this).closest('.row').find('.row-body .lw-row-setting').toggleClass('active');
    });

    jQuery(row).find('.lw-row-setting .close').click(function(e){  
        e.preventDefault();         
        jQuery(this).closest('.row').find('.row-name').html(jQuery(this).closest('.lw-popup').find('.lw-name').val());     
        jQuery(this).closest('.row').find('.row-width').html(jQuery(this).closest('.lw-popup').find('.lw-width').val());  
        jQuery(this).closest('.row').find('.row-css').html(jQuery(this).closest('.lw-popup').find('.lw-css-class').val());          
        
        jQuery(this).closest('.lw-popup').toggleClass('active');
    });

    jQuery(row).find('.btn-delete-row').click(function(e){  
        e.preventDefault();
        if(confirm('Would you like to delete?')){
            jQuery(this).closest('.box').remove();
        }
    });

    jQuery(row).find('.btn-up-row').click(function(e){  
        e.preventDefault(); 
        doUp(this);
    });

    jQuery(row).find('.btn-down-row').click(function(e){  
        e.preventDefault();
        doDown(this);
    });

    return row;
}
function getColumnHtml(body_html){
    var column = jQuery('\
        <div class="column col-3 box" data-index="'+(++index)+'">\
            <div class="content column-content">\
                <div class="header column-header">\
                    Column: <strong class="column-name"></strong>\
                    <div class="right">\
                        <a href="#" class="btn btn-add btn-add-item" data-index="'+index+'" >Add Item</a>  \
                        <a href="#" class="btn btn-edit btn-edit-column" ><i class="fas fa-edit"></i></a>  \
                        <a href="#" class="btn btn-delete btn-delete-column" ><i class="fas fa-trash"></i></a>  \
                        <a href="#" class="btn btn-up btn-up-column" ><i class="fas fa-caret-square-up"></i></a>  \
                        <a href="#" class="btn btn-down btn-down-column" ><i class="fas fa-caret-square-down"></i></a>  \
                    </div>\
                    <select class="column-size">\
                        <option value="1">1</option>\
                        <option value="2">2</option>\
                        <option value="3" selected>3</option>\
                        <option value="4">4</option>\
                        <option value="5">5</option>\
                        <option value="6">6</option>\
                        <option value="7">7</option>\
                        <option value="8">8</option>\
                        <option value="9">9</option>\
                        <option value="10">10</option>\
                        <option value="11">11</option>\
                        <option value="12">12</option>\
                    </select>\
                </div>\
                <div class="body column-body">'+body_html+'</div>\
            </div>\
        </div>');

    jQuery(column).find('.btn-add-item').click(function(e){  
        e.preventDefault();
        jQuery('.lw-widget-items').toggleClass('active');
        jQuery('.lw-widget-items').attr('data-index', jQuery(this).attr('data-index'));
    });

    jQuery(column).find('.btn-edit-column').click(function(e){  
        e.preventDefault();          
        jQuery(this).closest('.column').find('.column-body .lw-column-setting').toggleClass('active');
    });

    jQuery(column).find('.lw-column-setting .close').click(function(e){  
        e.preventDefault();         
        jQuery(this).closest('.column').find('.column-name').html(jQuery(this).closest('.lw-popup').find('.lw-name').val());
        jQuery(this).closest('.lw-popup').toggleClass('active');
    });

    jQuery(column).find('.column-size').change(function(){  
        for(var i=1; i<=12; i++){
            jQuery(this).closest('.box').removeClass('col-'+i);
        }
        jQuery(this).closest('.box').addClass('col-'+jQuery(this).val());
    });

    jQuery(column).find('.btn-delete-column').click(function(e){ 
        e.preventDefault(e); 
        if(confirm('Would you like to delete?')){
            jQuery(this).closest('.box').remove();
        }
    });

    jQuery(column).find('.btn-up-column').click(function(e){  
        e.preventDefault(); 
        doUp(this);
    });

    jQuery(column).find('.btn-down-column').click(function(e){  
        e.preventDefault();
        doDown(this);
    });

    return column;
}
function getItemHtml(body_html, item_title=''){
    var item = jQuery('\
        <div class="item box" data-index="'+(++index)+'">\
            <div class="header item-header">\
                Item: <strong class="item-name"></strong>\
                <div class="right">\
                    <a href="#" class="btn btn-delete btn-delete-item" ><i class="fas fa-trash"></i></a>  \
                    <a href="#" class="btn btn-up btn-up-item" ><i class="fas fa-caret-square-up"></i></a>  \
                    <a href="#" class="btn btn-down btn-down-item" ><i class="fas fa-caret-square-down"></i></a>  \
                </div>\
            </div>\
            <div class="body item-body">\
                <input type="button" class="btn-edit-item button button-primary" value="'+item_title+'"> \
                <div class="lw-popup">\
                    <div class="lw-popup-content">\
                        <div class="lw-popup-header"><div class="title">'+item_title+'</div> <a class="close" href="#">Close</a></div>\
                        <div class="lw-popup-body">\
                            '+body_html+'\
                        </div>\
                    </div>\
                </div>\
            </div>\
        </div>'); 

    jQuery(item).find('.btn-delete-item').click(function(e){ 
        e.preventDefault(); 
        if(confirm('Would you like to delete?')){
            jQuery(this).closest('.box').remove();
        }
    });

    jQuery(item).find('.btn-edit-item').click(function(e){
        e.preventDefault(); 
        var item = jQuery(this).closest('.item'); 

        jQuery(item).find('.item-body .lw-popup').toggleClass('active');
    });

    jQuery(item).find('.btn-up-item').click(function(e){  
        e.preventDefault(); 
        doUp(this);
    });

    jQuery(item).find('.btn-down-item').click(function(e){  
        e.preventDefault();
        doDown(this);
    });
    
    jQuery(item).find('.lw-popup .close').click(function(e){
        e.preventDefault();
        jQuery(this).closest('.lw-popup').toggleClass('active');

        var item = jQuery(this).closest('.item');
        jQuery(item).find('.item-name').html(jQuery(item).find('.lw-name').val());
    });

    jQuery(item).find('.lw-editor-call').click(function(e){
        e.preventDefault();

        jQuery('.lw-editor.lw-popup').closest('.widget-inside').show();
        
        var value = jQuery(this).parent().find('.lw-editor').val();
        var fieldKey = jQuery(this).parent().find('.lw-editor').attr('field-key');
        var index = jQuery(this).closest('.item').attr('data-index');
        
        if(value){
            tinymce.editors['lw-editor'].setContent(value);
        }
            
        jQuery('.lw-editor.lw-popup').attr('data-index', index);
        jQuery('.lw-editor.lw-popup').attr('data-field', fieldKey);
        jQuery('.lw-editor.lw-popup').toggleClass('active');
    });

    return item;
}
function doUp(e){ 
    var box = jQuery(e).closest('.box');
    var parent = jQuery(box).parent();
    var index = jQuery(parent).find('>.box').index(box);
    
    if(index > 0) {
        jQuery(box).insertBefore(jQuery(parent).find('>.box')[index-1]);
        jQuery(box).addClass('moved');
    }
}
function doDown(e){ 
    var box = jQuery(e).closest('.box');
    var parent = jQuery(box).parent();
    var index = jQuery(parent).find('>.box').index(box);
    var max = jQuery(parent).find('>.box').length - 1;
    console.log('down');
    if(index < max) {
        jQuery(box).insertAfter(jQuery(parent).find('>.box')[index+1]);
        jQuery(box).addClass('moved');
    }
}
function getJson(main_id){   
    var arr = {
        'row_arr': []
    };
    jQuery('.lw-widget-container[data-lw-id="'+main_id+'"]').each(function(){
        jQuery(this).find('.row.box').each(function(){
            var id, name, display_name, css_class, background_image_url, full_width;
            id = jQuery(this).attr('data-index');
            name = jQuery(this).find('.lw-row-setting .setting.lw-name').val();
            display_name = jQuery(this).find('.lw-row-setting .setting.lw-display-name').is(":checked");
            css_class = jQuery(this).find('.lw-row-setting .setting.lw-css-class').val();
            background_image_url = jQuery(this).find('.field.box .setting.lw-background-image-url').val();
            background_color = jQuery(this).find('.field.box .setting.lw-background-color').val();
            full_width = jQuery(this).find('.field.box .setting.lw-full-width').val();

            var row = {
                'id': id,
                'type': 'row',
                'name': name,
                'display_name': display_name,
                'css_class': css_class,
                'full_width': full_width,                
                'background_image_url': background_image_url,
                'background_color': background_color,
                'column_arr': []
            }
            arr.row_arr.push(row);

            jQuery(this).find('.column.box').each(function(){
                var id, name, display_name, css_class, size, background_image_url;
                id = jQuery(this).attr('data-index');
                name = jQuery(this).find('.lw-column-setting .setting.lw-name').val();
                display_name = jQuery(this).find('.lw-column-setting .setting.lw-display-name').is(":checked");
                css_class = jQuery(this).find('.lw-column-setting .setting.lw-css-class').val();
                background_image_url = jQuery(this).find('.field.box .setting.lw-background-image-url').val();
                size = jQuery(this).find('.column-size').val();

                var column = {
                    'id': id,
                    'type': 'column',
                    'name': name,
                    'display_name': display_name,
                    'css_class': css_class,
                    'background_image_url': background_image_url,
                    'size': size,
                    'item_arr': []
                }
                row.column_arr.push(column);

                jQuery(this).find('.item.box').each(function(){
                    var id, name, display_name, css_class, widget_name, background_image_url;
                    id = jQuery(this).attr('data-index');
                    name = jQuery(this).find('.field.box .setting.lw-name').val();
                    display_name = jQuery(this).find('.field.box .setting.lw-display-name').is(":checked");
                    css_class = jQuery(this).find('.field.box .setting.lw-css-class').val();
                    background_image_url = jQuery(this).find('.field.box .setting.lw-background-image-url').val();
                    widget_name = jQuery(this).find('.widget-fields').attr('widget-name');
        
                    var item = {
                        'id': id,
                        'type': 'item',
                        'name': name,
                        'display_name': display_name,
                        'css_class': css_class,
                        'background_image_url': background_image_url,
                        'widget_name': widget_name,
                        'field_arr': []
                    }
                    column.item_arr.push(item);

                    jQuery(this).find('.field-value').each(function(){
                        var key = jQuery(this).attr('field-key');
                        var val, type;
                        if(jQuery(this).hasClass('checkbox')){
                            val = jQuery(this).is(':checked');
                            type = 'check';
                        }else{
                            val = jQuery(this).val();
                            type = 'text';
                        }

                        item.field_arr.push({
                            'field': key, 'value': val,'type': type
                        });
                    });
                });
            });
        });
    }); 

    return arr;
}
function load_widget(main_id){
    var json = JSON.parse(jQuery('.lw_widgets_json[data-lw-id="'+main_id+'"] textarea').val());
    var widgetItems = jQuery('.lw-widget-items[data-lw-id="'+main_id+'"]');
    
    // row
    if(!json['row_arr'])
        return;

    for(var row_index=0; row_index<json['row_arr'].length; row_index++){        
        var jsonRow = json['row_arr'][row_index];
        var body_html = jQuery('.lw-widget-items .lw-row-setting').parent().html();
        var row = getRowHtml(body_html);
        
        jQuery('.lw-widget-container[data-lw-id="'+main_id+'"]').append(row);

        jQuery(row).find('.header .row-name').html(jsonRow['name']);
        jQuery(row).find('.header .row-width').html(jsonRow['full_width']);
        jQuery(row).find('.header .row-css').html(jsonRow['css_class']);
        jQuery(row).find('.lw-row-setting .setting.lw-name').val(jsonRow['name']);
        jQuery(row).find('.lw-row-setting .setting.lw-display-name').prop('checked', jsonRow['display_name']);
        jQuery(row).find('.lw-row-setting .setting.lw-css-class').val(jsonRow['css_class']);
        jQuery(row).find('.lw-row-setting .setting.lw-background-image-url').val(jsonRow['background_image_url']);
        jQuery(row).find('.lw-row-setting .setting.lw-background-color').val(jsonRow['background_color']);
        jQuery(row).find('.lw-row-setting .setting.lw-full-width').val(jsonRow['full_width']);
        
        // column
        if(!jsonRow['column_arr'])
            continue;

        for(var col_index=0; col_index<jsonRow['column_arr'].length; col_index++){        
            var jsonColumn = jsonRow['column_arr'][col_index];
            var body_html = jQuery(widgetItems).find('.lw-column-setting').parent().html(); 
            var col = getColumnHtml(body_html);
            
            jQuery(row).find('.row-body').append(col);

            jQuery(col).find('.header .column-name').html(jsonColumn['name']);
            jQuery(col).find('.column-size').val(jsonColumn['size']);
            jQuery(col).find('.column-size').change();
            jQuery(col).find('.lw-column-setting .setting.lw-name').val(jsonColumn['name']);
            jQuery(col).find('.lw-column-setting .setting.lw-display-name').prop('checked', jsonColumn['display_name']);
            jQuery(col).find('.lw-column-setting .setting.lw-css-class').val(jsonColumn['css_class']);
            jQuery(col).find('.lw-column-setting .setting.lw-background-image-url').val(jsonColumn['background_image_url']);

            // item
            if(!jsonColumn['item_arr'])
                continue;
                
            for(var item_index=0; item_index<jsonColumn['item_arr'].length; item_index++){        
                var jsonItem = jsonColumn['item_arr'][item_index]; 
                var body_html = jQuery(widgetItems).find('.field-group.'+jsonItem['widget_name']).find('.field-group-body').html(); 
                var item_title = jQuery(widgetItems).find('.field-group.'+jsonItem['widget_name']).find('.field-group-header').text();
                var item = getItemHtml(body_html, item_title);

                jQuery(col).find('.column-body').append(item); 

                jQuery(item).find('.header .item-name').html(jsonItem['name']);
                jQuery(item).find('.field.box .setting.lw-name').val(jsonItem['name']);
                jQuery(item).find('.field.box .setting.lw-display-name').prop('checked', jsonItem['display_name']);
                jQuery(item).find('.field.box .setting.lw-css-class').val(jsonItem['css_class']);
                jQuery(item).find('.field.box .setting.lw-background-image-url').val(jsonItem['background_image_url']);

                // field
                if(!jsonItem['field_arr'])
                    continue;
                
                for(var field_index=0; field_index < jsonItem['field_arr'].length; field_index++){
                    var jsonField = jsonItem['field_arr'][field_index];
                    if(jsonField['type'] == 'text'){
                        jQuery(item).find('.field-value.'+jsonField['field']).val(jsonField['value']);
                    }else if(jsonField['type'] == 'check'){
                        jQuery(item).find('.field-value.'+jsonField['field']).prop('checked', (jsonField['value']));
                    }
                }
            }
        }
    }
}
