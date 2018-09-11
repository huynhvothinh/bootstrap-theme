var index = 45;
var result = '';
jQuery('.iedit').each(function(){
	var title = jQuery(this).find('.row-title').text();
	var id = jQuery(this).attr('id').replace('post-','');
	var url = jQuery(this).find('.view a').attr('href');
	
	var string = '<li><label class="menu-item-title"><input type="checkbox" class="menu-item-checkbox" name="menu-item[-1][menu-item-object-id]" value="4618" /> Tệp đính kèm</label><input type="hidden" class="menu-item-db-id" name="menu-item[-1][menu-item-db-id]" value="0" /><input type="hidden" class="menu-item-object" name="menu-item[-1][menu-item-object]" value="post" /><input type="hidden" class="menu-item-parent-id" name="menu-item[-1][menu-item-parent-id]" value="0" /><input type="hidden" class="menu-item-type" name="menu-item[-1][menu-item-type]" value="post_type" /><input type="hidden" class="menu-item-title" name="menu-item[-1][menu-item-title]" value="Tệp đính kèm" /><input type="hidden" class="menu-item-url" name="menu-item[-1][menu-item-url]" value="http://kb.crmviet.vn/tep-dinh-kem/" /><input type="hidden" class="menu-item-target" name="menu-item[-1][menu-item-target]" value="" /><input type="hidden" class="menu-item-attr_title" name="menu-item[-1][menu-item-attr_title]" value="" /><input type="hidden" class="menu-item-classes" name="menu-item[-1][menu-item-classes]" value="" /><input type="hidden" class="menu-item-xfn" name="menu-item[-1][menu-item-xfn]" value="" /></li>';
	
	string = string.split('[-1]').join('[-'+index+']');
	string = string.split('4618').join(id);
	string = string.split('Tệp đính kèm').join(title);
	string = string.split('http://kb.crmviet.vn/tep-dinh-kem/').join(url);
	
	result += string;
	index++;
});

console.log(result);

// ===============
jQuery('#postchecklist-most-recent').html('');
jQuery('#post-search-checklist').html('');