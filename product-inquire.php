<?php
/*
Plugin Name: UP Inquiry Listing
Version: 1.0
Author: urmilwp
Description: This pluging provide to product inquire
*/


function product_inquire_scripts() {

  wp_register_style( 'product-inquire-style', plugins_url('css/product-inquire.css', __FILE__) );
  wp_enqueue_style( 'product-inquire-style' );

  wp_register_style( 'reset_css', plugin_dir_url( __FILE__ ) . 'css/jquery.dataTables.css' );
  wp_enqueue_style('reset_css');	
  wp_enqueue_style( 'jquery-style', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css' );
  wp_enqueue_script('jquery');
  wp_enqueue_script( 'dataTables_js', plugin_dir_url( __FILE__ )  . 'js/jquery.dataTables.min.js', array( 'jquery' ) );

?>
<script>  
	jQuery(document).ready(function() {	
		jQuery('#inquireList').dataTable();
	});
	</script> 	
<?php	
	

}
add_action( 'admin_head', 'product_inquire_scripts' );

if(!is_admin()) {
	add_action( 'wp_enqueue_scripts', 'product_inquire_scripts' ); 
}	
/* Creating Menus */
function product_inquire_Menu()
{
	/* Adding menus */
	add_menu_page(__('Order Inquiry'),'Order Inquiry', 8,'proinq/inquirelist.php', 'inquire_list','',9);

}
add_action('admin_menu', 'product_inquire_Menu');

function inquire_list(){
	include "product-inquire-list.php";
}

function del_inquire_record() {
	
	global $wpdb;
	$tablename = $wpdb->prefix.'orders';
	$sql = "DELETE FROM $tablename WHERE id = ".$_REQUEST['del_id'];
	$wpdb->query($sql);
	die();
}
add_action('wp_ajax_del_inquire_record', 'del_inquire_record');
add_action('wp_ajax_nopriv_del_inquire_record', 'del_inquire_record');


?>
