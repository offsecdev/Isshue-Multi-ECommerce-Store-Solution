$(document).ready(function() {
    "use strict";
    $('#rootwizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
        var $total = navigation.find('li').length;
        var $current = index+1;
        var $percent = ($current/$total) * 100;
        $('#rootwizard .progress-bar').css({width:$percent+'%'});
    }});

    $('#rootwizard1').bootstrapWizard({onTabShow: function(tab, navigation, index) {
        var $total = navigation.find('li').length;
        var $current = index+1;
        var $percent = ($current/$total) * 100;
        $('#rootwizard1 .progress-bar').css({width:$percent+'%'});
    }});
});



