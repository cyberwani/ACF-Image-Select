=== Advanced Custom Fields: {{field_label}} Field ===
Contributors: cyberwani
Tags:
Requires at least: 3.6
Tested up to: 3.6
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Image Select addon for Advanced Custom Fields.

== Description ==

Image Select addon for Advanced Custom Fields.

= Compatibility =

This add-on will work with:

* version 4 and up
* version 3 and bellow (WIP)

== Installation ==

This add-on can be treated as both a WP plugin and a theme include.

= Plugin =
1. Copy the 'acf-{{field_name}}' folder into your plugins folder
2. Activate the plugin via the Plugins admin page

= Include =
1.	Copy the 'acf-image-select' folder into your theme folder (can use sub folders). You can place the folder anywhere inside the 'wp-content' directory
2.	Edit your functions.php file and add the code below (Make sure the path is correct to include the acf-image-select.php file)

`
add_action('acf/register_fields', 'register_fields');

function my_register_fields()
{
	include_once('acf-image-select/acf-image-select.php');
}
`

== Changelog ==

= 1.0.0 =
* Initial Release.

= 1.0.1 =
* Added image-extension property.
* Some Tweaks