(function($){


	/**
	 *  initialize_field
	 *
	 *  This function will initialize the $field.
	 *
	 *  @date	30/11/17
	 *  @since	5.6.5
	 *
	 *  @param	n/a
	 *  @return	n/a
	 */

	function initialize_field( $field ) {

		// On label click, change the input and class
		jQuery(document).on('click', '.acf-image-select label img, .acf-image-select label .acf-image-select-title', function(e) {
			var id         = jQuery(this).closest('label').attr('for');
			var parentList = jQuery(this).closest('ul.acf-image-select-list');

			parentList.find('.acf-image-select-selected').removeClass('acf-image-select-selected').find("input[type='radio']").attr("checked",false).removeAttr("data-checked");

			jQuery('label[for="' + id + '"]').addClass('acf-image-select-selected').find("input[type='radio']").attr("checked",true).attr("data-checked","checked");

		});

	}
	if (typeof acf.add_action !== 'undefined') {

		// ACF5

		acf.add_action('ready append', function($el) {

			acf.get_fields({ type : 'image_select'}, $el).each(function() {
				initialize_field($(this));
			});
		});

	} else {

		// ACF4

		$(document).on('acf/setup_fields', function(e, postbox){

			$(postbox).find('.field[data-field_type="image_select"]').each(function(){
				initialize_field($(this));
			});

		});
	}




})(jQuery);
