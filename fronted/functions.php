<?php


// Register Custom Post Type
function rx_order_custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Order Forms', 'Post Type General Name', 'order_domain' ),
		'singular_name'         => _x( 'Order Form', 'Post Type Singular Name', 'order_domain' ),
		'menu_name'             => __( 'Order Forms', 'order_domain' ),
		'name_admin_bar'        => __( 'Order Form', 'order_domain' ),
		'archives'              => __( 'Item Archives', 'order_domain' ),
		'attributes'            => __( 'Item Attributes', 'order_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'order_domain' ),
		'all_items'             => __( 'All Items', 'order_domain' ),
		'add_new_item'          => __( 'Add New Item', 'order_domain' ),
		'add_new'               => __( 'Add New', 'order_domain' ),
		'new_item'              => __( 'New Item', 'order_domain' ),
		'edit_item'             => __( 'Edit Item', 'order_domain' ),
		'update_item'           => __( 'Update Item', 'order_domain' ),
		'view_item'             => __( 'View Item', 'order_domain' ),
		'view_items'            => __( 'View Items', 'order_domain' ),
		'search_items'          => __( 'Search Item', 'order_domain' ),
		'not_found'             => __( 'Not found', 'order_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'order_domain' ),
		'featured_image'        => __( 'Featured Image', 'order_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'order_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'order_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'order_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'order_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'order_domain' ),
		'items_list'            => __( 'Items list', 'order_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'order_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'order_domain' ),
	);
	$args = array(
		'label'                 => __( 'Order Form', 'order_domain' ),
		'description'           => __( 'Order Form Description', 'order_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-carrot',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'order_form', $args );

}
add_action( 'init', 'rx_order_custom_post_type', 0 );

// Register Custom Taxonomy
function rx_order_custom_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Order Taxonomies', 'Taxonomy General Name', 'order_taxo_domain' ),
		'singular_name'              => _x( 'Order Taxonomy', 'Taxonomy Singular Name', 'order_taxo_domain' ),
		'menu_name'                  => __( 'Order Category', 'order_taxo_domain' ),
		'all_items'                  => __( 'All Items', 'order_taxo_domain' ),
		'parent_item'                => __( 'Parent Item', 'order_taxo_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'order_taxo_domain' ),
		'new_item_name'              => __( 'New Item Name', 'order_taxo_domain' ),
		'add_new_item'               => __( 'Add New Item', 'order_taxo_domain' ),
		'edit_item'                  => __( 'Edit Item', 'order_taxo_domain' ),
		'update_item'                => __( 'Update Item', 'order_taxo_domain' ),
		'view_item'                  => __( 'View Item', 'order_taxo_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'order_taxo_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'order_taxo_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'order_taxo_domain' ),
		'popular_items'              => __( 'Popular Items', 'order_taxo_domain' ),
		'search_items'               => __( 'Search Items', 'order_taxo_domain' ),
		'not_found'                  => __( 'Not Found', 'order_taxo_domain' ),
		'no_terms'                   => __( 'No items', 'order_taxo_domain' ),
		'items_list'                 => __( 'Items list', 'order_taxo_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'order_taxo_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'exclude_from_search'        => false,
		'query_var'              	 => true,
	);
	register_taxonomy( 'order_cat', array( 'order_form' ), $args );

}
add_action( 'init', 'rx_order_custom_taxonomy', 0 );


function rx_order_ajax_scripts() {

	wp_enqueue_script( 'frontend-ajax', get_stylesheet_directory_uri() . '/assets/js/frontend-ajax.js', array('jquery'));
	wp_localize_script( 'frontend-ajax', 'frontendajax', array('ajaxurl' => admin_url('admin-ajax.php'),));
}
//add_action( 'wp_enqueue_scripts', 'rx_order_ajax_scripts' );

// get cat parent + Product Name assign data
function rx_get_cat_parent(){
	
	 $parent_id = $_POST['parentId'];
	 $parent_slug = $_POST['parentSlug'];


        $get_parent_id = get_term_by('slug', $parent_slug, 'order_cat');
        $parent_id = $get_parent_id->term_id;

        $parentcat = get_terms( 'order_cat', 'hide_empty=0&parent='.$parent_id);
            foreach ($parentcat as $child) {
            	
            	$option .= '<option data-cat-child-slug="'.$child->slug.'" data-cat-child-id="'.$child->term_id.'" value="'.$child->name.'">';
                $option .= $child->name;
                $option .= '</option>';
            }
        echo '<option value="0" seleordersd="seleordersd">Select Product</option>'.$option;
        //echo $option;
        die();


}
add_action('wp_ajax_nopriv_rx_get_cat_parent', 'rx_get_cat_parent');
add_action('wp_ajax_rx_get_cat_parent', 'rx_get_cat_parent');

// get cat child + + Product Description assign data
function rx_get_cat_child(){

	$childcat_id = $_POST['childparentId'];
	$childparent_slug = $_POST['childparentSlug'];

	$get_parent_id = get_term_by('slug', $childparent_slug, 'order_cat');
        $childcat_id = $get_parent_id->term_id;

        $parentcat = get_terms( 'order_cat', 'hide_empty=0&child_of='.$childcat_id);
            foreach ($parentcat as $child) {
            	$option .= '<option data-cat-child-id="'.$child->term_id.'" value="'.$child->name.'">';
                $option .= $child->name;
                $option .= '</option>';
            }
        echo '<option value="0" seleordersd="seleordersd">Select Product</option>'.$option;
        //echo $option;
        die();

}
add_action('wp_ajax_nopriv_rx_get_cat_child', 'rx_get_cat_child');
add_action('wp_ajax_rx_get_cat_child', 'rx_get_cat_child');

function rx_order_submit(){
	global $wpdb;
		
		$variableData = $_REQUEST['data'];
		$userData = array();
		$productArray = array();
		foreach ($variableData as $key => $value) {
			if (strpos($value['name'], 'product_') !== false) {	
				if(!empty($value['value'])){			
    				$productArray[$value['name']][] =  $value['value'];
    			}else {
    				$productArray[$value['name']][] =  " ";
    			}				    		
			}
			else{
				$userData[$value['name']] =  $value['value'] ;
			}
		}

		$customer_name			= $userData['customer_name'];
		$customer_email			= $userData['customer_email'];
		$mobile_number			= $userData['mobile_number'];
		$product_data			= serialize($productArray);

		$nowdate = date('Y-m-d H:i:s',time());
		$dataInsert =	 array(
				"customer_name" => $customer_name,
				"customer_email"=> $customer_email,
				"mobile_number" => $mobile_number,
				"product_data" 	=> $product_data,				
				"date" 			=> $nowdate,		
				);
		
		$order = $wpdb->insert(
			$wpdb->prefix."orders",
			$dataInsert,
			array( 
				'%s', 
				'%s', 
				'%s',
				'%s',
				'%s'
			) 
		);
		$orderID = $wpdb->insert_id;
		
		if($order){			
			$msg = "Your Order added successfully";
			$status = true;
		}
		else{
			$status = false; 
			$msg = "Something went Wrong.";
		}

			$mailData = array();
			foreach ($productArray as $key => $value) {
				foreach ($value as $k => $product) {
					
					$mailData[$k][$key] = $product;				
				}				
			}
			
		
		if($status){
		
		############################# send email start ##########################
			
			$admin_email = get_option( 'admin_email' ); 
			$multiple_recipients = array($customer_email,$admin_email);


			$subject = 'Order ID - "'.$orderID.'" From Test';
			
			$headers = "";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			$message = "";
			$message = '<html><body>';
			$message .= "<strong>Name: </strong>".$customer_name;
			$message .= "<br>";
			$message .= "<strong>Email : </strong>".$customer_email;
			$message .= "<br>";
			$message .= "<strong>Mobile : </strong>".$mobile_number;
			$message .= "<br>";
				         
                $message .= "<table width='100%' border='1' cellspacing='1' cellpadding='1'>
                    <tr>
                        <th colspan='5' align='center' height='40'>Product Details</th>
                    </tr>
                    <tr>
                        <td align='center' valign='middle' width='20%' height='60'>
                            <p style='font-size:18px;line-height:24px;color:#000;font-weight:bold;'>Sr. No</p>
                        </td>
                        <td align='center' valign='middle' width='20%'>
                            <p style='font-size:18px;line-height:24px;color:#000;font-weight:bold;'> Product Group </p>
                        </td>
                        <td align='center' valign='middle' width='20%'>
                            <p style='font-size:18px;line-height:24px;color:#000;font-weight:bold;'> Product Name </p>
                        </td>
                        <td align='center' valign='middle' width='20%'>
                            <p style='font-size:18px;line-height:24px;color:#000;font-weight:bold;'> Product Description </p>
                        </td>
                        <td align='center' valign='middle' width='20%'>
                            <p style='font-size:18px;line-height:24px;color:#000;font-weight:bold;'> Product Quantity </p>
                        </td>
                    </tr>";

                    $k=1;
					foreach ($mailData as $index => $tr) {
							
						$message .= "<tr>";
						$message .= "<td height='15' align='center'><p style='font-size:18px;line-height:24px;color:#000;'>".$k."</p></td>";
						$message .= "<td height='15' align='center'><p style='font-size:18px;line-height:24px;color:#000;'>".$tr['product_group']."</p></td>";
						$message .= "<td height='15' align='center'><p style='font-size:18px;line-height:24px;color:#000;'>".$tr['product_name']."</p></td>";
						$message .= "<td height='15' align='center'><p style='font-size:18px;line-height:24px;color:#000;'>".$tr['product_description']."</p></td>";
						$message .= "<td height='15' align='center'><p style='font-size:18px;line-height:24px;color:#000;'>".$tr['product_qty']."</p></td>";
						$message .= "</tr>";

						$k++;
					}
                
                
                $message .= "</table>";
           	$message .= "</body></html>";	

			
			$mailsent = wp_mail($multiple_recipients,$subject,$message,$headers);
			
			
		}
			############################# send email end ############################
		$response_array = array( 'status' => $status, 'message' => $msg);
		echo json_encode($response_array);
			
		die();

}
add_action('wp_ajax_nopriv_rx_order_submit', 'rx_order_submit');
add_action('wp_ajax_rx_order_submit', 'rx_order_submit');


// Add Shortcode
function up_custom_shortcode($atts) { 
	ob_start();
	?>
	
	<div id="book-order-form">
		
		<form role="form" id="book_order_form" class="row premier-order-form" method="POST" action="">
			<div class="frm-field col-md-4 form-group">
				<label for="customer_name">Customer Name <span class="required">*</span></label>
				<input type="text" name="customer_name" id="customer_name" class="isrequired form-control">
			</div>
			<div class="frm-field col-md-4 form-group">
				<label for="customer_email">Customer Email <span class="required">*</span></label>
				<input type="email" name="customer_email" id="customer_email" class="isrequired form-control">
			</div>
			<div class="frm-field col-md-4 form-group">
				<label for="mobile_number">Mobile Number <span class="required">*</span></label>
				<input type="text" name="mobile_number" id="mobile_number" class="isrequired form-control" maxlength="10"></textarea>
			</div>
			<div class="dublicate_field_wrapper col-md-12" id="dublicate_section_warp_main">
				<div class="input_fields_wrap row" id="product_group_1" data-attr="1">
					
					<div class="frm-field col-md-6 form-group ">
						<label for="product_group">Product Group <span class="required">*</span></label>
						<div class="custom_select_box">
						<?php
					        $orders_category_terms = get_terms('order_cat', array('hide_empty' => false, 'parent' => 0 ));
					        if ( !empty($orders_category_terms) ) :
				                	echo '<select class="form-control form-control-lg font-light get_parent isrequired" name="product_group" id="product_group" >
			                                    <option value="" seleordersd="seleordersd">Select Products</option>';
			                                   foreach ( $orders_category_terms as $orders_category_term ) : ?>
			                                   			<option class="get_cat_parent_value" data-cat-parent-slug="<?php echo $orders_category_term->slug; ?>"  data-cat-parent-id="<?php echo $orders_category_term->term_id; ?>" value="<?php echo $orders_category_term->name; ?>"><?php echo $orders_category_term->name; ?></option>
			                             <?php endforeach;
			                        echo '</select>';

					        endif;       
					    ?>
						</div>
					</div>    
				    <div class="frm-field col-md-6 form-group">
						<label for="product_name">Product Name</label>
						<div class="custom_select_box">
							<select id="child" class="form-control form-control-lg font-light get_cat_child child" name="product_name" disabled="disabled"></select>
							</div>
					</div>
					<div class="frm-field col-md-6 form-group">
						<label for="product_description">Product Description</label>
						<div class="custom_select_box">
							<select id="pro_child_desc" class="form-control form-control-lg font-light pro_child_desc" name="product_description" disabled="disabled"></select>
							</div>
					</div>
				    <div class="frm-field col-md-6 form-group">
						<label for="product_qty">Order Qty <span class="required">*</span></label>
						<input type="text" name="product_qty" id="product_qty" class="isrequired form-control product_qty"></textarea>
					</div>
				</div>
			</div>
				<div class="col-md-12 text-right mt-2 mb-2"><a id="add_field_button" class="add_more_fields"><span>+</span> Add More Products</a></div>
			<div class="frm-field col-md-12 mt-2">
				<input class="submit_book_btn  btn text-red regular-font diagonal-swipe submit" type="button" value="Order">
				
			</div>
			<div class=" col-md-12 mt-3  "><div id="notic_book_order" class="alert"></div></div>
		</form>
	</div>


	<?php

	$html = ob_get_contents();
	ob_end_clean();
	return $html;
}
add_shortcode( 'order_frm', 'up_custom_shortcode' );
//[order_frm]



add_filter( 'wp_mail_from', 'custom_wp_mail_from' );
function custom_wp_mail_from( $original_email_address ) {
	return 'wordpress@domain.com';
}
