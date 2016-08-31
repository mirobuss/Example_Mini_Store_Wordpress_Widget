<?php 
defined('ABSPATH') or die('Access denied'); //Denies direct access
//Action hook to register our metabox in control panel
add_action('add_meta_boxes', 'ems_register_meta_box');

function ems_register_meta_box(){
	add_meta_box('ems_product_meta', __('Product Information','ems_plugin'), 'ems_meta_box', 'ems_products', 'side', 'default' );
}

//Callback function triggered by ems_register_meta_box(). Provides the HTML view of the metabox 
function ems_meta_box($post){
	//Retrieving information from DB and assign it to variables
	$ems_meta = get_post_meta($post->ID, '_ems_product_data', true); 
	$ems_sku = (!empty($ems_meta['sku'])) ? $ems_meta['sku'] : '';
	$ems_price = (!empty($ems_meta['price'])) ? $ems_meta['price'] : '';
	$ems_weight = (!empty($ems_meta['weight'])) ? $ems_meta['weight'] : '';
	$ems_color = (!empty($ems_meta['color'])) ? $ems_meta['color'] : '';
	$ems_inventory = (!empty($ems_meta['inventory'])) ? $ems_meta['inventory'] : '';
	
	//Creating nonce
	wp_nonce_field('meta-box-save', 'sec_key'); 
	
	//HTML view of the meta box
	echo '<table>';
	echo '<tr>';
	echo '<td>'.__('SKU','ems_plugin').':</td>
	<td><input type="text" name="ems_product[sku]" value="'.esc_attr($ems_sku).'" size="10"/></td>';
	echo '</tr><tr>';
	echo '<td>'.__('Price','ems_plugin').':</td>
	<td><input type="text" name="ems_product[price]" value="'.esc_attr($ems_price).'" size="5"/></td>';
	echo '</tr><tr>';
	echo '<td>'.__('Weight','ems_plugin').':</td>
	<td><input type="text" name="ems_product[weight]" value="'.esc_attr($ems_weight).'" size="5"/></td>';
	echo '</tr><tr>';
	echo '<td>'.__('Color','ems_plugin').':</td>
	<td><input type="text" name="ems_product[color]" value="'.esc_attr($ems_color).'" size="5"/></td>';
	echo '</tr><tr>';
	echo '<td>Inventory:</td>
	<td>
	<select name="ems_product[inventory]" id="ems_product[inventory]">
		<option value="In Stock"'
		.selected($ems_inventory, 'In Stock', false)
		.'>'.__('In Stock', 'ems_plugin').'</option>
		
		<option value="Backordered"'
		.selected($ems_inventory, 'Backordered', false)
		.'>'.__('Backordered', 'ems_plugin').'</option>
		
		<option value="Out of Stock"'
		.selected($ems_inventory, 'Out of Stock', false)
		.'>'.__('Out of Stock', 'ems_plugin').'</option>
		
		<option value="Discontinued"'
		.selected($ems_inventory, 'Discontinued', false)
		.'>'.__('Discontinued', 'ems_plugin').'</option>
		</select></td>';
		echo '</tr>';
		
	//display the metabox shortcode legend
	echo '<tr><td colspan="2"><hr></td></tr>';
	echo '<tr><td colspan="2"><strong>'
 .__( 'Shortcode Legend',
 'ems_plugin' ).'</strong></td></tr>';
	 echo '<tr><td>'
 .__( 'Sku', 'ems_plugin' ) .':</td>
 <td>[ems show=sku]</td></tr>';
 echo '<tr><td>'
 .__( 'Price', 'ems_plugin' ).':</td>
 <td>[ems show=price]</td></tr>';
 echo '<tr><td>'
 .__( 'Weight', 'ems_plugin' ).':</td>
 <td>[ems show=weight]</td></tr>';
 echo '<tr><td>'
 .__( 'Color', 'ems_plugin' ).':</td>
 <td>[ems show=color]</td></tr>';
 echo '<tr><td>'
 .__( 'Inventory', 'ems_plugin' ).':</td>
 <td>[ems show=inventory]</td></tr>';
 echo '</table>';
}

//Add action triggered when a product is saved
add_action('save_post', 'ems_save_meta_box');

function ems_save_meta_box($post_id){
	if(get_post_type($post_id)=='ems_products' && isset($_POST['ems_product'])){
		//avoid autosave
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
			return;
		}
    //check the nonce and save metadata
		if(wp_verify_nonce($_REQUEST['sec_key'],'meta-box-save')){
		$ems_product_data = $_POST['ems_product'];
		//In this case array_map() provides shorter code than using foreach	
		$ems_product_data = array_map('sanitize_text_field', $ems_product_data);
		update_post_meta($post_id, '_ems_product_data', $ems_product_data);
		}
	}
}
?>