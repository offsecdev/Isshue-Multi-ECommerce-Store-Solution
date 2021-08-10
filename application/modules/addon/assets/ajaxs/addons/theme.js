"use strict";
 $(".delete_item").on('click', function(e){
    var item_name = $(this).attr('data_id');
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    var base_url = $("#base_url").val();

    swal({
         title: "Are you sure?",
         text: "You will not be able to recover this theme!",
         type: "warning",
         confirmButtonText: "Yes, delete it!",
        confirmButtonColor: '#3085d6',
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        cancelButtonText: "No, cancel plx!",
        cancelButtonColor: '#d33'
     }).then((willDelete) => {
         if (willDelete.value) {
             $.ajax({
                type: 'POST',
                url: base_url + 'addon/theme/theme_delete',
                data: {"csrf_test_name": CSRF_TOKEN,"theme":item_name},
                 success: function(data) {
                      $(".theme_"+item_name).remove();
                      swal("Deleted!", "Your theme has been deleted.", "success");
                 },
                 error: function() {
                    swal("Failed!", "Failed Please try again", "error");
                 }
              })
         } else {
             swal("Cancelled", "Your theme file is safe :)", "success");
         }
     });
 });