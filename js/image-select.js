jQuery(document).ready(function() {

	// On label click, change the input and class
	jQuery(document).on('click', '.acf-image-select label img, .acf-image-select label .acf-image-select-title', function(e) {
		var id         = jQuery(this).closest('label').attr('for');
		var parentList = jQuery(this).closest('ul.acf-image-select-list');
		
		parentList.find('.acf-image-select-selected').removeClass('acf-image-select-selected').find("input[type='radio']").attr("checked",false).removeAttr("data-checked");
		
		jQuery('label[for="' + id + '"]').addClass('acf-image-select-selected').find("input[type='radio']").attr("checked",true).attr("data-checked","checked");
		
	});
	
});