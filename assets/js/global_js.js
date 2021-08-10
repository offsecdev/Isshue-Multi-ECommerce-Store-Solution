
"use strict";
var myResponse = "";
var base_url = $('#base_url').val();
var CSRF_TOKEN = $('#CSRF_TOKEN').val();
var language_id = $('#language_id').val();

$.ajax({
    url: base_url+'assets/js/language.json',
    async: false,
    method: 'post',
    dataType: 'json',
    global: false,
    contentType: 'application/json',
    success: function (data) {
        var obj = JSON.stringify(data);
        myResponse=obj;
    }
});
   
var getPhrase = JSON.parse(myResponse);
function display(item) {
    if(typeof(getPhrase[item]) != "undefined" &&
     getPhrase[item] !== null) {
        return getPhrase[item][language_id];
    }
    return false;
}
// Base URL
function get_base_url(item){
    return base_url + item;
}

function editLang(id,language){
    var phase_value = $('#'+id).val();    
    var base_url = $('#base_url').val();
    var CSRF_TOKEN = $('#CSRF_TOKEN').val();
    
    $.ajax({
        url:base_url+"dashboard/Language/languagePhaseUpdate",
        type: 'POST',
        data: {'csrf_test_name': CSRF_TOKEN,'id':id,'phase_value':phase_value,'language':language}, 
        success: function (res){ 
                       
            toastr.success(res, " ", {
                "timeOut": "200",
                "extendedTImeout": "200"
            });   
        },
        error: function (){
             toastr.warning("Failed");
        }
    });

}
