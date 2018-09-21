jQuery(document).ready(function(){
    jQuery('.lw-theme-setting').closest('form').each(function(){
        load_data();
        get_data_json();
    });
});

function get_data_json(){
    jQuery('input[type="submit"]').click(function(){
        var settingJson = {
            'template-search': '',
            'template-tag': '',
            'template-single-default': '',
            'template-page-default': '',
            'template-product-default': '',
            'template-category-default': '',
            'template-product-category-default': '',
            'template-category-arr': [],
            'template-category-single-arr': []
        }

        settingJson['template-search'] = jQuery('.dropdown-template.template-search').val();
        settingJson['template-tag'] = jQuery('.dropdown-template.template-tag').val();
        settingJson['template-category-default'] = jQuery('.dropdown-template.template-category-default').val();
        settingJson['template-product-category-default'] = jQuery('.dropdown-template.template-product-category-default').val();
        settingJson['template-single-default'] = jQuery('.dropdown-template.template-single-default').val();
        settingJson['template-page-default'] = jQuery('.dropdown-template.template-page-default').val();
        settingJson['template-product-default'] = jQuery('.dropdown-template.template-product-default').val();

        jQuery('tr.template-category').each(function(){
            settingJson['template-category-arr'].push({
                'category-id': jQuery(this).attr('data-id'),
                'template-id': jQuery(this).find('.dropdown-template.template-category').val()
            });
        });
        
        jQuery('tr.template-category-single').each(function(){
            settingJson['template-category-single-arr'].push({
                'category-id': jQuery(this).attr('data-id'),
                'template-id': jQuery(this).find('.dropdown-template.template-category-single').val()
            });
        });

        jQuery('#lw_settings').val(JSON.stringify(settingJson)); 
    });
}

function load_data(){
    var data = jQuery('#lw_settings').val();   
    if(data){
        var settingJson = JSON.parse(data);
        jQuery('.dropdown-template.template-search').val(settingJson['template-search']);
        jQuery('.dropdown-template.template-tag').val(settingJson['template-tag']);
        jQuery('.dropdown-template.template-category-default').val(settingJson['template-category-default']);
        jQuery('.dropdown-template.template-product-category-default').val(settingJson['template-product-category-default']);
        jQuery('.dropdown-template.template-single-default').val(settingJson['template-single-default']);
        jQuery('.dropdown-template.template-page-default').val(settingJson['template-page-default']);
        jQuery('.dropdown-template.template-product-default').val(settingJson['template-product-default']);

        var arr = [];
        arr = settingJson['template-category-arr'];
        for(var i=0; i<arr.length; i++){
            var id = arr[i]['category-id'];
            var value = arr[i]['template-id'];
            jQuery('tr.template-category[data-id="'+id+'"]')
                .find('.dropdown-template.template-category').val(value);
        }

        arr = settingJson['template-category-single-arr'];
        for(var i=0; i<arr.length; i++){
            var id = arr[i]['category-id'];
            var value = arr[i]['template-id'];
            jQuery('tr.template-category-single[data-id="'+id+'"]')
                .find('.dropdown-template.template-category-single').val(value);
        }
    }
}