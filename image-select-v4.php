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
	
	function create_field( $field )
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
				if( $field['value'] === false )
				{
					if( $i === 1 )
					{
						$atts = 'checked="checked" data-checked="checked"';
						$class = 'acf-image-select-selected';
					}
				}
				else
				{
					if( strval($key) === strval($field['value']) )
					{
						$atts = 'checked="checked" data-checked="checked"';
						$class = 'acf-image-select-selected';
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
	
	
	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	
	function create_options( $field )
	{
		// vars
		$key = $field['name'];
		
		// implode checkboxes so they work in a textarea
		if( is_array($field['choices']) )
		{		
			foreach( $field['choices'] as $k => $v )
			{
				$field['choices'][ $k ] = $k . ' : ' . $v;
			}
			$field['choices'] = implode("\n", $field['choices']);
		}
		?>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label for=""><?php _e("Choices",'acf'); ?></label>
				<p class="description"><?php _e("Enter your choices one per line",'acf'); ?><br>
				<?php _e("Red",'acf'); ?><br /><?php _e("Blue",'acf'); ?><br>
				<?php _e("red : Red",'acf'); ?><br /><?php _e("blue : Blue",'acf'); ?></p>
			</td>
			<td>
				<?php
				
				do_action('acf/create_field', array(
					'type'	=>	'textarea',
					'class' => 	'textarea field_option-choices',
					'name'	=>	'fields['.$key.'][choices]',
					'value'	=>	$field['choices'],
				));
				
				?>
				<div class="image-select-option-description">
					<p class="description">
						<?php _e("<span style='color:#BC0B0B'>Please note:</span> The first value of each choices will used as name of image.<br>Like for '<strong>Blue</strong>' or '<strong>blue : Blue</strong>', the image name will be '<strong>blue.png</strong>' .",'acf'); ?>
					</p>
				</div>
			</td>
		</tr>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Default Value",'acf'); ?></label>
			</td>
			<td>
				<?php
				
				do_action('acf/create_field', array(
					'type'	=>	'text',
					'name'	=>	'fields['.$key.'][default_value]',
					'value'	=>	$field['default_value'],
				));
				
				?>
			</td>
		</tr>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Allow Multiple Choices?",'acf'); ?></label>
			</td>
			<td>
				<?php
				do_action('acf/create_field', array(
					'type'	=>	'radio',
					'name'	=>	'fields['.$key.'][multiple]',
					'value'	=>	$field['multiple'],
					'choices'	=>	array(
						1	=>	__("Yes",'acf'),
						0	=>	__("No",'acf'),
					),
					'layout'	=>	'horizontal',
				));
				?>
			</td>
		</tr>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Image Path",'acf'); ?></label>
				<p class="description"><?php _e("Enter complete URL for images.",'acf'); ?></p>
			</td>
			<td>
				<?php
				
				do_action('acf/create_field', array(
					'type'	=>	'text',
					'name'	=>	'fields['.$key.'][image_path]',
					'value'	=>	$field['image_path'],
				));
				
				?>
				<div class="image-select-option-description">
					<p class="description">
						<?php _e("<span style='color:#BC0B0B'>Some Important Paths:</span>'",'acf'); ?>
						<ul>
							<li><strong>Theme URL:</strong> <?php echo get_template_directory_uri();?> (<em><u>If current theme is child theme.</u></em>)</li>
							<li><strong>Current/Child Theme:</strong> <?php echo get_stylesheet_directory_uri();?></li>
							<li><strong>Content Folder:</strong> <?php echo content_url();?></li>
							<li><strong>Home URL:</strong> <?php echo home_url();?></li>
						</ul>
					</p>
				</div>
			</td>
		</tr>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Image Extension",'acf'); ?></label>
			</td>
			<td>
				<?php
				
				do_action('acf/create_field', array(
					'type'	=>	'text',
					'name'	=>	'fields['.$key.'][image_extension]',
					'value'	=>	$field['image_extension'],
				));
				
				?>
			</td>
		</tr>
		<?php
		
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
		wp_register_script('acf-input-image-select', $this->settings['dir'] . 'js/image-select.js', array('acf-input'), $this->settings['version']);
		wp_enqueue_script(array(
			'acf-input-image-select',
		));
		
		// styles
		wp_register_style('acf-input-image-select', $this->settings['dir'] . 'css/image-select.css', array('acf-input'), $this->settings['version']);
		wp_enqueue_style(array(
			'acf-input-image-select',
		));
	}
	
	
	/*
	*  update_value()
	*
	*  This filter is appied to the $value before it is updated in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value - the value which will be saved in the database
	*  @param	$post_id - the $post_id of which the value will be saved
	*  @param	$field - the field array holding all the field options
	*
	*  @return	$value - the modified value
	*/
	
	function update_field( $field, $post_id )
	{
		
		// check if is array. Normal back end edit posts a textarea, but a user might use update_field from the front end
		if( is_array( $field['choices'] ))
		{
		    return $field;
		}
		
		// vars
		$new_choices = array();
		
		
		// explode choices from each line
		if( $field['choices'] )
		{
			// stripslashes ("")
			$field['choices'] = stripslashes_deep($field['choices']);
		
			if(strpos($field['choices'], "\n") !== false)
			{
				// found multiple lines, explode it
				$field['choices'] = explode("\n", $field['choices']);
			}
			else
			{
				// no multiple lines! 
				$field['choices'] = array($field['choices']);
			}
			
			
			// key => value
			foreach($field['choices'] as $choice)
			{
				if(strpos($choice, ' : ') !== false)
				{
					$choice = explode(' : ', $choice);
					$new_choices[ trim($choice[0]) ] = trim($choice[1]);
				}
				else
				{
					$new_choices[ trim($choice) ] = trim($choice);
				}
			}
		}
		
		
		// update choices
		$field['choices'] = $new_choices;
		
		
		return $field;
	}
	
}

new acf_field_image_select();

?>