<?php 
defined('ABSPATH') or die('Access denied'); //Denies direct access

//Action hook to provide shortcode
add_shortcode('ems','ems_shortcode');

function ems_shortcode($atts, $content=null){
	
	global $post;
	
	extract(shortcode_atts(array(
		'show' => ''
	), $atts)); 

	//load options array
	$ems_options_arr = get_option('ems_options');
	
	//load product data
	$ems_product_data = get_post_meta($post->ID, '_ems_product_data', true);
  // and perfotm the conditional logic  
	switch($show) {
			
		case 'sku':       $ems_show =(!empty($ems_product_data['sku'])) ? $ems_product_data['sku']:'';
		                  break;
		case 'price':     $ems_show=$ems_options_arr['currency_sign'];
			                $ems_show =(!empty($ems_product_data['price'])) ? $ems_show.$ems_product_data['price']:'';
		                  break;
		case 'weight':    $ems_show =(!empty($ems_product_data['weight'])) ? $ems_product_data['weight']:'';
		                  break;
		case 'color':     $ems_show =(!empty($ems_product_data['color'])) ? $ems_product_data['color']:'';
		                  break;
		case 'inventory':	$ems_show =(!empty($ems_product_data['inventory'])) ? $ems_product_data['inventory']:'';
											break;
		default:	        $ems_show=__('ERROR: You have not entered your tag properly','ems_plugin');
	}
		return $ems_show;
	} 
?>