$(document).ready(function () {
    "use strict";
    // select 2 dropdown 
    $("select.form-control:not(.dont-select-me)").select2({
        placeholder: "Select option",
        allowClear: true
    });

    //form validate
    $("#validate").validate();
    $("#add_category").validate();
    $("#add_supplier").validate();

    $('.product-list').slimScroll({
        size: '3px',
        height: '345px',
        allowPageScroll: true,
        railVisible: true
    });

    $('.product-grid').slimScroll({
        size: '3px',
        height: '720px',
        allowPageScroll: true,
        railVisible: true
    });

    //summernote
    $('.summernote').summernote({
        height: 300, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: true     // set focus to editable area after initializing summernote
    });

});