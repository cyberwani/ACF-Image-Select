# ACF - Image Select Addon

Adds a new choice field 'Image Select' field type to ACF field list to add image-select field.

-----------------------

### Overview

The 'Image Select' field allows you to add images as radio button.

### Compatibility

This add-on will work with:

* version 4 and up
* version 3 and bellow


### Installation

This add-on can be treated as both a WP plugin and a theme include.

**Install as Plugin**

1. Copy the 'acf-image-select' folder into your plugins folder
2. Activate the plugin via the Plugins admin page

**Include within theme**

1.	Copy the 'acf-image-select' folder into your theme folder (can use sub folders). You can place the folder anywhere inside the 'wp-content' directory
2.	Edit your functions.php file and add the code below (Make sure the path is correct to include the acf-image-select.php file)

```php
add_action('acf/register_fields', 'register_fields');

function my_register_fields()
{
	include_once('acf-image-select/acf-image-select.php');
}
```
