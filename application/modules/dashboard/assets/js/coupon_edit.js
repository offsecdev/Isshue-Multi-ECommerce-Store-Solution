"use strict";

  function dis_type(type)
    {
        if(type.value == "1" ){
            document.getElementById("percentage").style.display="none";
            document.getElementById("amount").style.display="block"; 
        }else{
            document.getElementById("amount").style.display="none"; 
            document.getElementById("percentage").style.display="block";
        }
    }



