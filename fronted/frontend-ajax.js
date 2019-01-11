jQuery(document).ready(function($) {

	// get cat parent + Product Name assign data
	jQuery(document).on('change', '.get_parent', function($) { 
		
		var formData = jQuery("#book_order_form").serialize();
    	var ajaxurl = frontendajax.ajaxurl;
    	//var catID = jQuery(this).val();
    	var catID = jQuery(this).find("option:selected").attr('data-cat-parent-id');
     	var catSlug = jQuery(this).find("option:selected").attr('data-cat-parent-slug');

     	var parentsID = jQuery(this).parents('.input_fields_wrap').attr('data-attr'); //.find('.frm-field .child');
     	
     	var htmlDiv = jQuery('#product_group_'+parentsID).find('.frm-field .child');
     	//console.log(htmlDiv);
        jQuery.ajax({
            type   : "POST",
            //dataType : "json",
            url    : ajaxurl,
            data   : {
                      data: formData,
                      action : "rx_get_cat_parent",
                      parentId : catID,
                      parentSlug:catSlug,
                    },
                success:function(data){
                	//alert(data);
                	//$('#child').html(data);
                
	              	htmlDiv.removeAttr("disabled");
                    htmlDiv.html(data);
            			
                }
        });
        return false;
    });
	// get cat child + + Product Description assign data
	jQuery(document).on('change', '.get_cat_child', function($) {	
      	var formData = jQuery("#book_order_form").serialize();
		var ajaxurl = frontendajax.ajaxurl;
 		//var childcatID = jQuery(this).val();
 		var childcatID = jQuery(this).find(':selected').attr('data-cat-child-id');
     	var childcatSlug = jQuery(this).find(':selected').attr('data-cat-child-slug');

     	var parentsID = jQuery(this).parents('.input_fields_wrap').attr('data-attr'); //.find('.frm-field .child');
     	
     	var htmlDiv = jQuery('#product_group_'+parentsID).find('.frm-field .pro_child_desc');
    
        jQuery.ajax({
            type   : "POST",
            //dataType : "json",
            url    : ajaxurl,
            data   : {
                      data: formData,
                      action : "rx_get_cat_child",
                      childparentSlug:childcatSlug,
                      childparentId : childcatID,
                    },
                success:function(data){
                		//jQuery(".pro_child_desc").removeAttr("disabled");
                        //jQuery(".pro_child_desc").html(data);

                        htmlDiv.removeAttr("disabled");
                    	htmlDiv.html(data);
            	}
        });
        return false;
    });

	jQuery("#notic_book_order.alert").hide();

	jQuery(document).on('click', '.submit_book_btn', function() {
	//jQuery(".submit_book_btn").click(function() {
		
		//on focus
		jQuery("#book_order_form .isrequired, #book_order_form .isrequired").focus(function(){
			jQuery(this).removeClass('error');
		});
		
		//on blur
		jQuery("#book_order_form .isrequired, #book_order_form .isrequired").blur(function()
		{
			if(jQuery(this).val().trim() == '')
			{
				jQuery(this).addClass('error');
			} else {
				jQuery(this).removeClass('error');
			}
		});	
		
		if(jQuery("#customer_name").val().trim() == '' || jQuery("#mobile_number").val().trim() == '' || jQuery("#product_group").val().trim() == '' || jQuery("#product_qty").val().trim() == '' ){
	
				jQuery("#notic_book_order.alert").show();
				jQuery("#notic_book_order.alert").addClass("alert-danger");
				jQuery("#notic_book_order.alert").html("Please fill all mandatory fields"); 
				
				jQuery("#book_order_form .isrequired" ).each(function() {	
					filedValue = jQuery(this).val().trim();
					if(filedValue == '')
					{
						jQuery(this).addClass('error');
					} else {
						jQuery(this).removeClass('error');
					}

				});

				jQuery("#mobile_number").on("keypress keyup blur",function (event) {    
	           		jQuery(this).val($(this).val().replace(/[^\d].+/, ""));
		            if ((event.which < 48 || event.which > 57)) {
		                event.preventDefault();
		            }
		            jQuery(this).addClass('error');
	        	});
			   jQuery(".product_qty").on("keypress keyup blur",function (event) {    
	           		jQuery(this).val($(this).val().replace(/[^\d].+/, ""));
		            if ((event.which < 48 || event.which > 57)) {
		                event.preventDefault();
		            }
		            jQuery(this).addClass('error');
	        	});
		
		}else if (!ValidateEmail(jQuery("#customer_email").val())) {
			
				jQuery("#notic_book_order.alert").show();
				jQuery("#notic_book_order.alert").addClass("alert-danger");
				jQuery("#notic_book_order.alert").html("Please enter valid email address");
				jQuery("#customer_email").addClass('error');
		
		}else {
			
			//jQuery("#order_form_loding").show();
			//var formData = jQuery("#book_order_form").serialize();
			var formData = jQuery("#book_order_form").serializeArray();
			var ajaxurl = frontendajax.ajaxurl;

			jQuery.ajax({
					type   : "POST",
		           	/*dataType: 'JSON',*/
		            url    : ajaxurl,
		            data   : {
		                      data: formData,
		                      action : "rx_order_submit",
		                      
		                    },

		        	success:function(data) {
							jQuery("#notic_book_order.alert").show();
							jQuery("#notic_book_order.alert").addClass("alert-success");
							jQuery("#notic_book_order.alert").html("Your Order added successfully");
							jQuery("#book_order_form")[0].reset();
							
							/*if(data.status){

				        			jQuery("#notic_book_order.alert").show();
				        			jQuery("#notic_book_order.alert").addClass("alert-success");
				        			jQuery("#notic_book_order.alert").html(data.message);
				        			jQuery("#book_order_form")[0].reset();
				            	
				            } else {
								   jQuery("#notic_book_order.alert").show();
				        			jQuery("#notic_book_order.alert").addClass("alert-danger");
				        			jQuery("#notic_book_order.alert").html(data.message);        
				            }*/

					},
					error: function(errorThrown){
						//console.log(errorThrown);
					}
			}); 
		}		
	});

	/**************************************/

});

function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
};
