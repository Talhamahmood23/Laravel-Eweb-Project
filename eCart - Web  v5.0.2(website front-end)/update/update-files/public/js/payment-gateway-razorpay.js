"use strict";

window.onload = function(){
    var options = {
        "key": document.getElementById("razorpay_key").value, // Enter the Key ID generated from the Dashboard
        "amount": document.getElementById("razorpay_amount").value, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
        
        "name": document.getElementById("razorpay_name").value,
        "description": "",
        "image": document.getElementById("logo").value,
        
        "handler": function (response){
           
            document.getElementById("razorpay_payment_id").value = response.razorpay_payment_id;
         
            document.forms[0].submit();
        },
        "modal": {
            "ondismiss": function(){
                window.location.replace(document.getElementById("cancel_url").value);
            }
        },
        "prefill": {
            "name": document.getElementById("loggedin_name").value,
            "email": document.getElementById("loggedin_email").value,
            "contact": document.getElementById("loggedin_contact").value
        },
        "theme": {
            "color": "#F37254"
        }
    };
    var rzp = new Razorpay(options);
    rzp.open();
}