<?php
/*
Plugin Name: Advanced Custom Fields: Image Select
Plugin URI: http://www.about/me/cyberwani
Description: Image Select addon for Advanced Custom Fields.
Version: 1.0.1
Author: Dinesh Kesarwani
Author URI: http://www.about/me/cyberwani
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


class acf_field_image_select_plugin
{
	/*
	*  Construct
	*
	*  @description:
	*  @since: 3.6
	*  @created: 04/02/2014
	*/

	function __construct()
	{
		// set text domain
		/*
		$domain = 'acf-image_select';
		$mofile = trailingslashit(dirname(__File__)) . 'lang/' . $domain . '-' . get_locale() . '.mo';
		load_textdomain( $domain, $mofile );
		*/


		// version 4+
		add_action('acf/register_fields', array($this, 'register_fields'));


		// version 3-
		add_action('init', array( $this, 'init' ), 5);
	}


	/*
	*  Init
	*
	*  @description:
	*  @since: 3.6
	*  @created: 04/02/2014
	*/

	function init()
	{
		if(function_exists('register_field'))
		{
			register_field('acf_field_image_select', dirname(__File__) . '/image-select-v3.php');
		}
	}

	/*
	*  register_fields
	*
	*  @description:
	*  @since: 3.6
	*  @created: 04/02/2014
	*/

	function register_fields()
	{
		include_once('image-select-v4.php');
	}

}

new acf_field_image_select_plugin();
?>