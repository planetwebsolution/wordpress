<?php 
/*
 Plugin Name: Wepay Refunds
 Plugin URI: http://www.example.com
 Description: This Plugin is used for refund wepay transactions
 Author: Yatendra Yadav
 Version: 1.0
 */

add_action( 'admin_enqueue_scripts', 'pricing_enquque_scripts' );
function pricing_enquque_scripts() {
	global $wp_version;
	$screen = get_current_screen();
	
	
	if ( $screen->id == "toplevel_page_wepay_refund/wepay")
	{
		
		?><link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
				<script src="//code.jquery.com/jquery-1.10.2.js"></script>
				<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
			
				<?php
		wp_enqueue_script( 'wep_script', plugins_url( 'js/wepscript.js', __FILE__ ) );
		wp_enqueue_style( 'wep_stylesheet', plugins_url( 'css/wepscript.css', __FILE__ ) );
		
		
		
	}
}


add_action( 'admin_menu', 'plugin_settings_page' );
function plugin_settings_page(){

	add_menu_page('Wepay Refunds', 'Wepay Refunds', 'manage_options', __FILE__, __FILE__);
	// Add a new submenu
	add_submenu_page(  __FILE__, 'Wepay Trans', 'Wepay Trans', 'manage_options', __FILE__, 'wepay_main_fun' );
//add_submenu_page(  __FILE__, 'Form2', 'Form2', 'manage_options', 'add-type', 'my_add_form2_fun' );
}

function wepay_main_fun(){
	
	
	
	include('all_transactions.php');
}
?>