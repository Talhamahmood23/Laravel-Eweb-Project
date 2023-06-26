"use strict";

$(document).ready(function(){
    $("#registerForm").on("submit", function(e){
        var form = $(this);
        form.find('button[type=submit]').attr('disabled', 'disabled');
        e.preventDefault();
        $.ajax({
            url : "#",
            type : 'POST',
            data : $(this).serialize(),    // multiple data sent using ajax
            success: function (response) {
                form.find('button[type=submit]').removeAttr('disabled');
                try{
                    var obj = JSON.parse(response);
                    if(obj.error === true){
                        $("#registerError").html(obj.message).show();
                    }else{
                        window.location.href = home +"my-account";
                    }
                }catch(ev){
                    form.find('button[type=submit]').removeAttr('disabled');
                }
            }
        });
    });
    $('select[name=city]').select2({placeholder:'Select City'});
    $('select[name=area]').select2({placeholder:'Select Area'});
    loadOptions($("select[name=city]"), "{{route('cities')}}", false, false, true, true);
    $('select[name=city]').change(function(){
        loadOptions($("select[name=area]"), "{{ route('area','') }}/" + $('select[name=city]').val(), true);
    });
});