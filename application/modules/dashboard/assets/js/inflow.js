"use strict";

	function bank_info_show(payment_type)
	{
        if(payment_type.value=="1"){
            document.getElementById("bank_info_hide").style.display="none";
        }else{
            document.getElementById("bank_info_hide").style.display="block";  
        }
	}
        
    function active_customer(status)
    {
        if(status=="payment_from_2"){
              document.getElementById("payment_from_2").style.display="none";
              document.getElementById("payment_from_1").style.display="block";
              document.getElementById("myRadioButton_2").checked = false;
              document.getElementById("myRadioButton_1").checked = true;
        }else{
              document.getElementById("payment_from_1").style.display="none";
              document.getElementById("payment_from_2").style.display="block";
              document.getElementById("myRadioButton_2").checked = false;
              document.getElementById("myRadioButton_1").checked = true;
            }
    }
