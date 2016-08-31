<?php
/*
 Plugin Name: Example Mini Store
 Description: Store widget to display product information. This plugin is ONLY for EDUCATIONAL purposes. I've created it as an example. There may be some bugs and of course someone could rewrite it in a far better way.
 Version: 1.0
 Author: Miro Hristov
 License: GPLv2
 */

defined('ABSPATH') or die('Access denied'); //Denies direct access

//This function is called when plugin is activated
register_activation_hook(__FILE__, 'example_mini_store_install');

//Callback function called by register_activation_hook();
function example_mini_store_install(){
	//setting up defaults
	$ems_options_arr = array('currency_sign' => '$');
	//save the default options
	update_option('ems_options', $ems_options_arr);
}
// Our plugin is activated, defaults are set up and we are ready to go

$dir = plugin_dir_path(__FILE__);
require_once($dir.'product_cpt.php'); //File that creates the custom post type 'Products'
require_once($dir.'settings_page.php'); //File that creates the settings page
require_once($dir.'widget_metabox.php'); //File that creates the metabox for our widget in control panel
require_once($dir.'shortcodes.php'); //File that creates and sets up shortcode tags
require_once($dir.'ems_widget.php'); //File that creates our widget and displays it to the world
?>