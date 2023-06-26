"use strict";

var addPhone = document.querySelector("#addPhone");
window.intlTelInput(addPhone);
var itiAdd = window.intlTelInputGlobals.getInstance(addPhone);

$(document).ready(function(){
    $("#formAddAddress").find('select[name=city]').select2({placeholder:'Select City'});
    $("#formAddAddress").find('select[name=area]').select2({placeholder:'Select Area'});
  loadOptions($("#formAddAddress").find("select[name=city]"), home + "cities", false, false, true);
    $("#formAddAddress").find('select[name=city]').change(function(){
        loadOptions($("#formAddAddress").find("select[name=area]"), home + "city/" + $("#formAddAddress").find('select[name=city]').val(), true);
    });
    $("#formAddAddress").on("submit", function(e){
        var c = $(".iti__selected-flag").attr('title').split(" ");
        c = c[c.length -1];
        $(this).find("input[name=country_code]").val(c);
        return true;
    });
    $('.AddEditAddressCancel').on("click", function(e){
        e.preventDefault();
        $("#editAddress").addClass("address-hide");
        $("#editAddress").removeClass("address-show");
        
        $("#addAddress").addClass("address-hide");
        $("#addAddress").removeClass("address-show");
        
        $("#address").addClass("address-show");
        $("#address").removeClass("address-hide");
    });
    addPhone.addEventListener("countrychange", function() {
        var c = itiAdd.getSelectedCountryData();
        $("#formAddAddress").find("input[name=country_code]").val("+" + c.dialCode);
    });
    $('.editAddress').on("click", function(e){
        e.preventDefault();
        $("#editAddress").removeClass("address-hide");
        $("#editAddress").addClass("address-show");
        
        $("#address").removeClass("address-show");
        $("#address").addClass("address-hide");
        var address = $(this).data('data');
        console.log(address);
        
        var editPhone = document.querySelector("#editPhone");
        window.intlTelInput(editPhone);
        var itiEdit = window.intlTelInputGlobals.getInstance(editPhone);

        itiEdit.setNumber(address.country_code);

        editPhone.addEventListener("countrychange", function() {
            var c = itiEdit.getSelectedCountryData();
            $("#formEditAddress").find("input[name=country_code]").val("+" + c.dialCode);
        });

        $("#formEditAddress").find('input[name=id]').val(address.id);
        $("#formEditAddress").find('input[name=name]').val(address.name);
        $("#formEditAddress").find('input[name=mobile]').val(address.mobile);
        $("#formEditAddress").find('input[name=alternate_mobile]').val(address.alternate_mobile);
        $("#formEditAddress").find('input[name=address]').val(address.address);
        $("#formEditAddress").find('input[name=landmark]').val(address.landmark);
        $("#formEditAddress").find('input[name=pincode]').val(address.pincode);
        $("#formEditAddress").find('input[name=state]').val(address.state);
        $("#formEditAddress").find('input[name=country]').val(address.country);
        $("#formEditAddress").find('input[name=type][value="' + address.type + '"]').attr('checked', 'checked');
        $("#formEditAddress").find('select[name=city]').select2({placeholder:'Select City'});
        $("#formEditAddress").find('select[name=area]').select2({placeholder:'Select Area'});
        if(address.is_default == 1){
            $("#formEditAddress").find('input[name=is_default]').prop('checked', 'checked');
        }else{
            $("#formEditAddress").find('input[name=is_default]').prop('checked', '');
        }
        loadOptions($("#formEditAddress").find("select[name=city]"), home + "cities", false, false, true, address.city_id);
        $("#formEditAddress").find('select[name=city]').change(function(){
            loadOptions($("#formEditAddress").find("select[name=area]"), home + "city/" + $("#formEditAddress").find('select[name=city]').val(), true, false, true, address.area_id);
        });
    });
});