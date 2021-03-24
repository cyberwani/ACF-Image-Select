<?php
/*
Plugin Name: Advanced Custom Fields: Image Select
Plugin URI: https://github.com/moderntribe/ACF-Image-Select/
Description: Image Select addon for Advanced Custom Fields. (Forked from http://www.about/me/cyberwani.)
Version: 1.0.2
Author: Modern Tribe
Author URI: http://tri.be
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
	

		// version 5+
		add_action('acf/include_fields', array($this, 'register_fields_v5'));

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
			register_field('acf_field_image_select', plugin_dir_path(__FILE__) . '/image-select-v3.php');
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


	/*
	*  register_fields
	*
	*  @description:
	*  @since: 3.6
	*  @created: 04/02/2014
	*/

	function register_fields_v5()
	{
		include_once('image-select-v5.php');
	}


}

new acf_field_image_select_plugin();
?>