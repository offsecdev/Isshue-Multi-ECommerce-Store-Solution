"use strict";
$("#add_supplier").on('submit',function(event)
{ 
    event.preventDefault();  
    var formdata = new FormData($(this)[0]);

    $.ajax({
        url:  $(this).attr("action"),
        type: $(this).attr("method"),
        data: formdata, 
        processData: false,
        contentType: false,
        success: function (data, status)
        {
            if (data == '1') {
                $('#message').css('display','block');
                $('#message').html('Supplier added successfully');
                setTimeout(function(){
                    window.location.href = window.location.href;
                }, 2000);
            }else if(data == '2'){
                $('#error_message').css('display','block');
                $('#error_message').html('Supplier already exist !');
            }else if(data == '3'){
                $('#error_message').css('display','block');
                $('#error_message').html('Supplier name and mobile is required!');
            }
        },
        error: function (xhr, desc, err)
        {


        }
    });        
});

$("#add_category").on('submit',function(event)
{ 
    event.preventDefault();  
    var formdata = new FormData($(this)[0]);

    $.ajax({
        url:  $(this).attr("action"),
        type: $(this).attr("method"),
        data: formdata, 
        processData: false,
        contentType: false,
        success: function (data, status)
        {
            if (data == '1') {
                $('#message1').css('display','block');
                $('#message1').html('Category added successfully');
                setTimeout(function(){
                    window.location.href = window.location.href;
                }, 1000);
            }else if (data == '2'){
                $('#error_message1').css('display','block');
                $('#error_message1').html('Category already exist !');
            }else if(data == '3'){
                $('#error_message1').css('display','block');
                $('#error_message1').html('Category name required!');
            }
        },
        error: function (xhr, desc, err)
        {


        }
    });        
});
