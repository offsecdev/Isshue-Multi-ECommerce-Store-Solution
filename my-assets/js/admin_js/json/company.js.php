"use strict";
<?php
$cache_file = "company.json";
    header('Content-Type: text/javascript; charset=utf8');
?>
var companyList = <?php echo file_get_contents($cache_file); ?> ; 
var csrf_test_name=  $("#CSRF_TOKEN").val();

var APchange = function(event, ui){
	$(this).data("autocomplete").menu.activeMenu.children(":first-child").trigger("click");
}
    $(function() {
      
        $( ".companySelection" ).autocomplete(
		{
            source:companyList,
			delay:300,
			focus: function(event, ui) {
				$(this).parent().find(".company_hidden_value").val(ui.item.value);
				$(this).val(ui.item.label);
				return false;
			},
			select: function(event, ui) {
				$(this).parent().find(".company_hidden_value").val(ui.item.value);
				$(this).val(ui.item.label);
				$(this).unbind("change");
				return false;
			}
		});
			$( ".companySelection" ).focus(function(){
				$(this).change(APchange);
			
			});
    });
