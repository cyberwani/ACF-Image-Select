<?php

class acf_field_image_select extends acf_field
{
	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function __construct()
	{
		// vars
		$this->name        = 'image_select';
		$this->label       = __('Image Select');
		$this->category    = __("Choice",'acf');
		$this->defaults    = array(
			'choices'			=>	array(),
			'default_value'		=>	'',
			'multiple'          => 0,
			'image_path'		=>	get_template_directory_uri() . '/images/',
			'image_extension'   => 'png',
		);
		
		// settings
		$this->settings = array(
			'path'				=> apply_filters('acf/helpers/get_path', __FILE__),
			'dir'				=> apply_filters('acf/helpers/get_dir', __FILE__),
			'version'=> '1.0.0'
		);
		
		// do not delete!
    	parent::__construct();
  
	}
	
		
	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function render_field( $field )
	{
		// vars
		$i = 0;
		$e = '<ul class="acf-image-select-list ' . esc_attr($field['class']) . '" data-image-select-multiple="'.$field['multiple'].'">';
		
		// add choices
		if( is_array($field['choices']) )
		{
			foreach( $field['choices'] as $key => $value )
			{
				// vars
				$i++;
				$atts  = '';
				$class = '';

				// if there is no value and this is the first of the choices, select this on by default
				if( $field['value'] === array() )
				{
					if( $i === 1 )
					{
						$atts = 'checked="checked" data-checked="checked"';
						$class = 'acf-image-select-selected';
					}
				}
				else
				{
					if( ! is_array($field['value']) )
					{
						if( strval($key) === strval($field['value']) )
						{
							$atts = 'checked="checked" data-checked="checked"';
							$class = 'acf-image-select-selected';
						}
					}
				}
				
				// HTML
				$field_id = esc_attr($field['id']) . '-' . esc_attr($key);
				$e .= '<li class="acf-image-select">';
					
					$e .= '<label for="' . $field_id . '" class="'.$class.'">';
						$e .= '<input id="' . $field_id . '" class="item-input" type="radio" name="' . esc_attr($field['name']) . '" value="' . esc_attr($key) . '" ' .  $atts  . ' />';
						$e .= '<img class="item-image ' . $field_id . '-image" alt="'.$value.'" src="'.$field['image_path'].esc_attr($key).'.'.$field['image_extension'].'">';
						$e .= '<br/>';
						$e .= '<span class="item-title ' . $field_id . '-title">'.$value.'</span>';
					$e .= '</label>';
				$e .= '</li>';
			}
		}
		
		$e .= '</ul>';
		
		echo $e;
		
	}
	

	function render_field_settings($field) {

		$field['choices'] = acf_encode_choices($field['choices']);


		acf_render_field_setting($field, array(
			'label' => __("Choices"),
			'type'	=>	'textarea',
			'name'	=>	'choices',
			'instructions' => "Enter your choices one per line. <br /><span style='color:#BC0B0B'>Please note:</span> The first value of each choices will used as name of image.<br>Like for '<strong>Blue</strong>' or '<strong>blue : Blue</strong>', the image name will be '<strong>blue.png</strong>"
		));

		acf_render_field_setting($field, array(
			'label'	=> __('Default Value'),
			'type'	=>	'text',
			'name'	=>	'default_value',
		));

		acf_render_field_setting($field, array(
			'label'	=> __('Allow Multiple Choices?'),
			'name'	=>	'multiple',
			'type'	=> 'radio',
			'choices'	=>	array(
				1	=>	__("Yes",'acf'),
				0	=>	__("No",'acf'),
			),
			'layout'	=>	'horizontal',
		));

		acf_render_field_setting($field, array(
			'label'	=> __('Image Path'),
			'instructions' => "Enter complete URL for images<br /><span style='color:#BC0B0B'>Some Important Paths:</span><ul>
					<li><strong>Theme URL:</strong>" . get_template_directory_uri() . "(<em><u>If current theme is child theme.</u></em>)</li>
					<li><strong>Current/Child Theme:</strong>" . get_stylesheet_directory_uri() . "</li>
					<li><strong>Content Folder:</strong>" .  content_url() . "</li>
					<li><strong>Home URL:</strong>" . home_url() . "</li>
				</ul>",
			'type'	=>	'text',
			'name'	=>	'image_path',
		));

		acf_render_field_setting($field, array(
			'label'	=> _('Image Extension'),
			'type'	=>	'text',
			'name'	=>	'image_extension',
		));
	}
	
	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add css + javascript to assist your create_field() action.
	*
	*  $info	http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function input_admin_enqueue_scripts()
	{
		// scripts
		wp_register_script('acf-input-image-select', plugins_url( 'js/image-select.js', __FILE__), array('acf-input'), $this->settings['version']);
		wp_enqueue_script(array(
			'acf-input-image-select',
		));
		
		// styles
		wp_register_style('acf-input-image-select', plugins_url( 'css/image-select.css', __FILE__), array('acf-input'), $this->settings['version']);
		wp_enqueue_style(array(
			'acf-input-image-select',
		));
	}
	
	
	/*
	*  update_field()
	*
	*  This filter is appied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field - the field array holding all the field options
	*  @param	$post_id - the field group ID (post_type = acf)
	*
	*  @return	$field - the modified field
	*/

	
	function update_field( $field ) {
		
		// decode choices (convert to array)
		$field['choices'] = acf_decode_choices($field['choices']);
		$field['default_value'] = acf_decode_choices($field['default_value']);
		
		
		// return
		return $field;
	}

	function update_value( $value, $post_id, $field ) {
		
		// validate
		if( empty($value) ) {
		
			return $value;
			
		}
		
		
		// array
		if( is_array($value) ) {
			
			// save value as strings, so we can clearly search for them in SQL LIKE statements
			$value = array_map('strval', $value);
			
		}
		
		
		// return
		return $value;
	}

	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/

	function format_value($value, $post_id, $field)
	{
		// bail early if no value
		if( empty($value) ) {
			return $value;	
		}


		// get value

		$retvalue = $field['image_path'] . esc_attr($value) . '.'.$field['image_extension'];

		// format value

		// return value
		return $retvalue;
	}

	
}

new acf_field_image_select();

?>
