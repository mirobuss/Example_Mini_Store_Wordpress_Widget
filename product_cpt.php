<?php
defined('ABSPATH') or die('Access denied'); //Denies direct access

//Registering Custom post type "Products"
add_action('init','ems_store_init');

function ems_store_init(){
	//Labels of products items used in $args
	$labels = array(
		'name'               => __('Products','ems_plugin'),
		'singular_name'      => __('Product', 'ems_plugin'),
		'add_new'            => __('Add new', 'ems_plugin'),
		'add_new_item'       => __('Add new product', 'ems_plugin'),
		'edit_item'          => __('Edit product', 'ems_plugin'),
		'new_item'           => __('New product', 'ems_plugin'),
		'all_items'          => __('All products', 'ems_plugin'),
		'view_item'          => __('View_product', 'ems_plugin'),
		'search_items'       => __('Search products', 'ems_plugin'),
		'not_found'          => __('No products found', 'ems_plugin'),
		'not_found_in_trash' => __('No products found in trash', 'ems_plugin'),
		'menu_name'          => __('Products', 'ems_plugin')
	);
	
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array('title', 'editor', 'thumbnail', 'excerpt')
	);
	
	register_post_type('ems_products', $args);
}
?>