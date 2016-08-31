<?php 
//Add action hook to create plugin widget
add_action('widgets_init','ems_register_widgets');

function ems_register_widgets(){
	register_widget('ems_widget');
}
//Creating custom class for our widget
class ems_widget extends WP_Widget{
	public function __construct(){
		$widget_ops=array(
		'classname' => 'ems-widget-class', //This is the (css) class name that will be placed automaticly in HTML tags.
		'description' => __('Display Example Mini Store Products','ems_plugin')	
		);
		
		parent::__construct('ems_widget', __('Products Widget','ems_plugint'), $widget_ops);
	}
	//build our widget settings form visible in Appearance/Widgets in dashboard
	public function form($instance){
		$defaults = array(
			'title' => __('Products', 'ems_plugin'),
			'number_products' => '3'
		);
		$instance = wp_parse_args((array)$instance, $defaults ); //Combines the stuff passed with $instance with defaul values in $defaults
		$title = $instance['title'];
		$number_products = $instance['number_products'];
		//HTML  for our widget settings
    ?>
    <p><?php _e('Title', 'ems_plugin'); ?>:
			<input class="widefat" name="<?php echo $this->get_field_name('title'); //This is a function of WP_Widget and should be used in form() methods of the class?>"
					   type="text" value = "<?php echo esc_attr($title);?>" />		 
    </p>
    <p><?php _e('Number of products', 'ems_plugin'); ?>:
			<input class="widefat" name="<?php echo $this->get_field_name('number_products');?>"
					   type="text" value = "<?php echo absint($number_products);?>" size="2" maxlength="2"/>			 
    </p>
<?php	
	}
	//save our widget settings
	public function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['number_products'] = absint($new_instance['number_products']);
		return $instance;
		//Notice that no form tags or submit button is needed. WP_Widget class takes care of this
	}
	
	//display our widget
	public function widget($args, $instance){
		global $post; 
	  //Passing the array elements of args into single variables
		extract($args);
		echo $before_widget; //example of a variable that were $args array element
		$title = apply_filters('widget_title', $instance['title']);
		$number_products = $instance['number_products'];
		if(!empty($title)){
			echo $before_title.esc_html($title).$after_title;
		}
		
	//Creating custom query to retrieve products
		$args=array(
			'post_type' => 'ems_products',
			'posts_per_page' => absint($number_products) 
		);
	
	$emsProducts = new WP_Query();
	$emsProducts->query($args); 
	//Custom loop to display our widget	
	while ($emsProducts->have_posts()){ 
		$emsProducts->the_post();
		$ems_options_arr = get_option('ems_options');
		$ems_product_data = get_post_meta($post->ID, '_ems_product_data', true );
		$ems_price = (!empty($ems_product_data['price'])) ? $ems_product_data['price'] : '';
		$ems_inventory = (!empty($ems_product_data['inventory'])) ? $ems_product_data['inventory'] : '';
		?>
  <p>
		<a href="<?php the_permalink();?>" rel="bookmark" 
			 title="<?php the_title_attribute();?> Product Information"><?php the_title();?></a>
  </p>
	<?php	
		echo '<p>'.__('Price','ems_plugin').': '.$ems_options_arr['currency_sign'].$ems_price.'</p>';
		//Check if show inventory option is avalible
		if($ems_options_arr['show_inventory']) 
		{ 
			echo '<p>'.__('Stock','ems_plugin').': '.$ems_inventory.'</p>';
		}
	echo '<hr>';	
	}
	wp_reset_postdata();
		echo $after_widget;
	}	
}
?>