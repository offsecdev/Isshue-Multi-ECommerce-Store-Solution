$(document).ready(function(){
    "use strict";
    var edit = $(".edit");
    var csrf_test_name=  $("#CSRF_TOKEN").val();

    edit.on('click', function()
    {
        var template = $(this).parent().prev().text();
        var type = $(this).parent().prev().prev().text();
        var name = $(this).parent().prev().prev().prev().text();
        var id = $(this).data('id');


        $("#id").val(id);
        $("#template_name").val(name); 
        $('select#type option[value='+type+']').attr("selected", "selected");  
        $("#message").html(template);

        $(".tit").text(display('sms_template_setup'));
        $("#MyForm").attr("action", 'template_update');
        $(".sav_btn").text(display('update')); 
    });
});
