var index = 0;

jQuery(document).ready(function(){
    wp.editor.initialize('hunghv');

    jQuery('.btn-show-settings').click(function(){ 
        jQuery('.settings.lw-popup').toggleClass('active');
    });    
    jQuery('.settings-header .close').click(function(e){
        e.preventDefault();
        jQuery(this).closest('.lw-popup').toggleClass('active');
    });

    jQuery('.btn-add-row').click(function(){ 
        var body_html = jQuery('.lw-widget-items .lw-row-setting').parent().html();
        jQuery('.lw-widget-container').append(getRowHtml(body_html));
    });
    
    jQuery('.lw-widget-container').click(function(e){ 
        setTimeout(function(){
            jQuery('.box').removeClass('moved');
        }, 2000)
    });
    
    jQuery('.lw-widget-items-header .close').click(function(e){
        e.preventDefault();
        jQuery('.lw-widget-items').toggleClass('active');        
    });

    jQuery('.field-group-header').click(function(){ 
        var index = jQuery(this).closest('.lw-widget-items').attr('data-index');
        var body_html = jQuery(this).closest('.field-group').find('.field-group-body').html();
        jQuery('.column[data-index="'+index+'"]').find('.column-body').append(getItemHtml(body_html));    
        //
        jQuery(this).closest('.lw-popup').toggleClass('active');         
    }); 

    jQuery('.lw-editor.lw-popup .close').click(function(){
        var index = jQuery('.lw-editor.lw-popup').attr('data-index');
        var item = jQuery('.item[data-index="'+index+'"]');
        jQuery('.lw-editor.lw-popup').toggleClass('active');
        jQuery(item).find('.lw-editor').val(tinymce.editors['lw-editor'].getContent());
        tinymce.editors['lw-editor'].setContent('');
    });
});

function getRowHtml(body_html){
    var row = jQuery('\
        <div class="row box index-'+(++index)+'">\
            <div class="header row-header">\
                Row: <strong class="row-name"></strong>\
                <a href="#" class="btn btn-add btn-add-column" >Add Column</a>  \
                <div class="right">\
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
        jQuery(this).closest('.row').find('.row-name').html(jQuery(this).closest('.lw-popup').find('.lw-row-name').val());
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
        <div class="column col-6 box" data-index="'+(++index)+'">\
            <div class="header column-header">\
                Column: <strong class="column-name"></strong>\
                <a href="#" class="btn btn-add btn-add-item" data-index="'+index+'" >Add Item</a>  \
                <div class="right">\
                    <a href="#" class="btn btn-edit btn-edit-column" ><i class="fas fa-edit"></i></a>  \
                    <a href="#" class="btn btn-delete btn-delete-column" ><i class="fas fa-trash"></i></a>  \
                    <a href="#" class="btn btn-up btn-up-column" ><i class="fas fa-caret-square-up"></i></a>  \
                    <a href="#" class="btn btn-down btn-down-column" ><i class="fas fa-caret-square-down"></i></a>  \
                </div>\
                <select class="column-size">\
                    <option value="1">1</option>\
                    <option value="2">2</option>\
                    <option value="3">3</option>\
                    <option value="4">4</option>\
                    <option value="5">5</option>\
                    <option value="6" selected>6</option>\
                    <option value="7">7</option>\
                    <option value="8">8</option>\
                    <option value="9">9</option>\
                    <option value="10">10</option>\
                    <option value="11">11</option>\
                    <option value="12">12</option>\
                </select>\
            </div>\
            <div class="body column-body">'+body_html+'</div>\
        </div>');

    jQuery(column).find('.btn-add-item').click(function(e){  
        e.preventDefault();
        jQuery('.lw-widget-items').toggleClass('active');
        jQuery('.lw-widget-items').attr('data-index', jQuery(this).attr('data-index'));
    });

    jQuery(column).find('.btn-edit-column').click(function(e){  
        e.preventDefault();         
        console.log('btn-edit-column(click)');
        jQuery(this).closest('.column').find('.column-body .lw-column-setting').toggleClass('active');
    });

    jQuery(column).find('.lw-column-setting .close').click(function(e){  
        e.preventDefault();         
        jQuery(this).closest('.column').find('.column-name').html(jQuery(this).closest('.lw-popup').find('.lw-column-name').val());
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
function getItemHtml(body_html){
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
                <input type="button" class="btn-edit-item button button-primary" value="Edit"> \
                <div class="lw-popup">\
                    <div class="lw-popup-content">\
                        <div class="lw-popup-header"><a class="close" href="#">Close</a></div>\
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
        jQuery(item).find('.item-name').html(jQuery(item).find('.lw-item-name').val());
    });

    jQuery(item).find('.lw-editor-call').click(function(e){
        e.preventDefault();
        var value = jQuery(this).parent().find('.lw-editor').val();
        var index = jQuery(this).closest('.item').attr('data-index');
        
        if(value){
            tinymce.editors['lw-editor'].setContent(value);
        }
            
        jQuery('.lw-editor.lw-popup').attr('data-index', index);
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