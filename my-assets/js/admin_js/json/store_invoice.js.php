"use strict";
<?php
	$cache_file = "product.json";
    header('Content-Type: text/javascript; charset=utf8');
?>
	var productList = <?php echo file_get_contents($cache_file); ?> ; 
	var csrf_test_name=  $("#CSRF_TOKEN").val();

	var APchange = function(event, ui){
		$(this).data("autocomplete").menu.activeMenu.children(":first-child").trigger("click");
	}
    function invoice_productList(cName) {
		var qnttClass = 'ctnqntt'+cName;
		var priceClass = 'price_item'+cName;
		var total_tax_price = 'total_tax_'+cName;
		var available_quantity = 'available_quantity_'+cName;
		var unit 			='unit_'+cName;
		var cgst			='cgst_'+cName;
		var sgst			='sgst_'+cName;
		var igst			='igst_'+cName;
		var variant			='variant_'+cName;
		var cgst_id			='cgst_id_'+cName;
		var sgst_id			='sgst_id_'+cName;
		var igst_id			='igst_id_'+cName;
		var variant_id  	='variant_id_'+cName;
		var discount  		='discount_'+cName;
		
        $( ".productSelection" ).autocomplete(
		{
            source: productList,
			delay:300,
			focus: function(event, ui) {
				$(this).parent().find(".autocomplete_hidden_value").val(ui.item.value);
				$(this).val(ui.item.label);
				return false;
			},
			select: function(event, ui) {
				$(this).parent().find(".autocomplete_hidden_value").val(ui.item.value);
				$(this).val(ui.item.label);
				
				var id=ui.item.value;
				var dataString = 'csrf_test_name='+csrf_test_name+'&product_id='+ id;
				var base_url = $('.baseUrl').val();
				$.ajax
				   ({
						type: "POST",
						url: base_url+"Store_invoice/retrieve_product_data",
						data: dataString,
						cache: false,
						success: function(data)
						{
							var obj = jQuery.parseJSON(data);
							$('.'+qnttClass).val(obj.cartoon_quantity);
							$('.'+priceClass).val(obj.price);
							$('.'+total_tax_price).val(obj.tax);
							//$('.'+available_quantity).val(obj.total_product);
							$('.'+unit).val(obj.unit);
							$('#'+cgst).val(obj.cgst_tax);
							$('#'+sgst).val(obj.sgst_tax);
							$('#'+igst).val(obj.igst_tax);
							$('#'+variant).val(obj.variant_id);
							$('#'+cgst_id).val(obj.cgst_id);
							$('#'+sgst_id).val(obj.sgst_id);
							$('#'+igst_id).val(obj.igst_id);
							$('#'+variant_id).html(obj.variant);
							$('#'+discount).val(obj.discount);

							//This Function Stay on others.js page
							quantity_calculate(cName);

						} 
					});
				
				$(this).unbind("change");
				return false;
			}
		});
		$( ".productSelection" ).focus(function(){
			$(this).change(APchange);
		});
    }