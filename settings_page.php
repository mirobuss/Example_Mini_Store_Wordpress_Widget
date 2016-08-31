<?php
defined('ABSPATH') or die('Access denied'); //Denies direct access
//Creating settings page
add_action('admin_menu', 'ems_settings_menu');

function ems_settings_menu(){
	add_options_page(__('Example Mini Store Settings page','ems_plugin'), 
									 __('Example Mini Store Settings','ems_plugin'), 'manage_options', 'ems_settings', 'ems_settings_page' );
}

//callback function executed by add_options_page()
function ems_settings_page(){
	//Load options and display them
	$ems_options_arr = get_option('ems_options');
	$ems_inventory = (!empty($ems_options_arr['show_inventory'])) ? $ems_options_arr['show_inventory'] : '';
	$ems_currency_sign = $ems_options_arr['currency_sign'];
	
//HTML view of the settings page	
?>
<div class = "wrap">
	<h2><?php _e('Example Mini Store Options', 'ems_plugin');?></h2>
	<form method="post" action="options.php">
	  <?php settings_fields('ems_settings_group');?>
		<table class="form-table">
			<tr valign="top">
			<th scope="row"><?php _e('Show product inventory', 'ems_plugin'); ?></th>
				<td><input type="checkbox" name="ems_options[show_inventory]" <?php echo checked($ems_inventory, 'on');?>/></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Currency sign', 'ems_plugin');?></th>
				<td><input type="text" name="ems_options[currency_sign]" value="<?php echo esc_attr($ems_currency_sign); ?>" size="1" maxlength="1"/></td>
			</tr>
		</table>
		<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes', 'ems_plugin'); ?>"/></p>
	</form>
</div>
<?php
}
//Activating Settings API	
add_action('admin_init', 'ems_register_settings');
	
function ems_register_settings(){
	register_setting('ems_settings_group', 'ems_options', 'ems_sanitize_options');
}
//Custom callback function for validating data, triggered by register_setting().	
function ems_sanitize_options($options){
		$options['show_inventory'] = (!empty($options['show_inventory'])) ? sanitize_text_field($options['show_inventory']) : '';
		$options['currency_sign'] = (!empty($options['currency_sign'])) ? sanitize_text_field($options['currency_sign']) : '';
		return $options;
}
?>