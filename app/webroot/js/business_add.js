Business = {
    init: function() {
       $(document).on('focus','#BusinessWebsite',function(){
                    trim($(this).val()) == '' ? $('#BusinessWebsite-error').html('') : "";
                    trim($(this).val()) == '' ? $(this).val("http://") : "";
        }).on('blur', '#BusinessWebsite', function (event) {
                    trim($(this).val()) == 'http://' ? $('#BusinessWebsite-error').html('') : "";
                    trim($(this).val()) == 'http://' ? $(this).val("") : "";
        });
        $(".select2").select2();
        $("#BusinessCategoryId").change(function() {
            Business.get_subcategories($("#BusinessCategoryId").val());
        });
        if ($("#BusinessCategoryId").val() > 0) {
            this.get_subcategories($("#BusinessCategoryId").val());
        }

        $("#BusinessCityId").change(function() {
            Business.get_localities($("#BusinessCityId").val());
        });
        if ($("#BusinessCityId").val() > 0) {
            this.get_localities($("#BusinessCityId").val());
        }
        
        if($("input:radio[name='BusinessType']:checked").val() == 'group'){
            Business.toggle_private_validate('remove');
        }
        $("input:radio[name='BusinessType']").change(function(){
            if ($(this).val() == 'group') {
                $('#privateBusinessBlock').fadeOut();
                Business.toggle_private_validate('remove');
            } else {
                $('#privateBusinessBlock').fadeIn();
                $(".select2").select2();
                Business.toggle_private_validate('add');
            }
        });
        $("input[type='radio'][name='data[Business][type]']").click(function () {
            if ($(this).attr("value") == "private") {
                $(".private_business").show().addClass('animated fadeInDown');
            } else {
                $(".private_business").removeClass('animated fadeInDown').hide();
            }
        });
        //, #BusinessEstablished
        //startDate: "01/01/1990",//endDate: "01/01/2020",
        $('#BusinessDob').datepicker({
            format: 'M dd, yyyy',dateFormat: 'M d, yy',maxDate: '0',autoclose:true,clearBtn:true,changeYear:true,changeMonth:true,yearRange: "-100:+0",startDate: "01/01/1901",endDate: new Date(),clearBtn: true
        });
        
        /*toggle discount options*/
        $('#discount_allowed').is(':checked')?$('.discount_allowed_blk').show():$('.discount_allowed_blk').hide();
        $('#discount_allowed').click(function(){
            $('#discount_allowed').is(':checked')?$('.discount_allowed_blk').show():$('.discount_allowed_blk').hide();
        });
    },
    set_address: function(address) {
        var adr = typeof address != 'undefined' && address.trim() != '' ? address.split(',') : new Array();
        var country = adr.pop();
        var state_pin_arr1 = adr.pop();
        var state_pin_arr = typeof state_pin_arr1 != 'undefined' ? state_pin_arr1.trim().split(' ') : new Array();
        //console.log(state_pin_arr)
        var pin = state_pin_arr.pop();
        var state = state_pin_arr.pop();
        var city = adr.pop();
        var locality = adr.pop();
        var addr = adr.join(',');
        typeof pin != 'undefined' && !isNaN(pin) && $('#BusinessPincode').val() == '' ? $('#BusinessPincode').val(pin) : '';
        typeof addr != 'undefined' && $('#BusinessAddress').val().trim() == '' ? $('#BusinessAddress').val(addr) : '';
        //typeof locality != 'undefined' ? $('#BusinessAddress').val(locality) : '';
    },
    geo_search: function(geocoder, map) {
        var address = '';//'Bhubaneswar, odisha';
        address += $("#BusinessAddress").val().trim() != '' ? "" + $("#BusinessAddress").val().trim()+"," : "";
        address += $("#BusinessLandmark").val().trim() != '' ? "" + $("#BusinessLandmark").val().trim()+"," : "";
        address += $("#BusinessLocalityId").val() > 0 ? "" + $("#BusinessLocalityId option:selected").html()+"," : "";
        address += $("#BusinessCityId").val() > 0 ? "" + $("#BusinessCityId option:selected").html() : "";
        //address += $("#BusinessPincode").val() != '' ? " " + $("#BusinessPincode").val() : "";
        //console.log(address)
        if (address != '') {
            geocodeAddress(geocoder, map, address);
        }
    },
    get_subcategories: function(catid) {
        return false;
        var params = {catid: catid};
        $.ajax({
            url: HTTP_ROOT + "content/subcats",
            data: params,
            method: 'post',
            //dataType: 'json',
            success: function(response) {
                //console.log($('#BusinessSubcategoryId').val())
                //console.log($("#BusinessSubcategoryId_tmp").val())
                //$("#BusinessSubcategoryId").find('option:gt(0)').remove();
                $("#BusinessSubcategoryId").find('option').remove();
                $("#BusinessSubcategoryId").append(response);
                if ($("#BusinessSubcategoryId_tmp").val() != '') {
                    $("#BusinessSubcategoryId").val($("#BusinessSubcategoryId_tmp").val().split(','));
                }
                $('#BusinessSubcategoryId').trigger('change');
                /*if (response.success == 1) {
                 if(typeof response.cats != 'undefined'){
                 //console.log(response.cats);
                 $("#BusinessSubcategoryId").find('option:gt(0)').remove();
                 $.each(response.cats,function(key,val){
                 $("<option>").attr('value',key).html(val).appendTo("#BusinessSubcategoryId");
                 });
                 }
                 }*/
            }
        });
    },
    get_localities: function(ctid) {
        var params = {ctid: ctid};
        $.ajax({
            url: HTTP_ROOT + "content/localities",
            data: params,
            method: 'post',
            //dataType: 'json',
            success: function(response) {
                //$("#BusinessLocalityId").find('option:gt(0)').remove();
                $("#BusinessLocalityId").find('option').remove();
                $("#BusinessLocalityId").append(response);
                //console.log(' >> '+$("#BusinessLocalityId_tmp").val())
                $("#BusinessLocalityId").val($("#BusinessLocalityId_tmp").val());
                $("#BusinessLocalityId").select2('val', $("#BusinessLocalityId_tmp").val());
                /*if (response.success == 1) {
                 if(typeof response.lct != 'undefined'){
                 //console.log(response.lct);
                 $("#BusinessLocalityId").find('option:gt(0)').remove();
                 $.each(response.lct,function(key,val){
                 //console.log(key+" >> "+val);
                 $("<option>").attr('value',key).html(val).appendTo("#BusinessLocalityId");
                 });
                 }
                 }*/
            }
        });
    },
    toggle_private_validate: function(mode){
        if(mode == 'add'){
            //$("input[name='data[Business][dob]']" ).rules("add", "required" );
            //$("input[name='data[Business][established]']" ).rules("add", "required" );
            $(" select[name='data[Business][languages][]']" ).rules("add", "required" );
            //$("input[name='data[Business][tagline]']" ).rules("add", "required" );
            $("textarea[name='data[Business][experience]']" ).rules("add", "required" );
            $("textarea[name='data[Business][education]']" ).rules("add", "required" );
        }else{
            //$("input[name='data[Business][dob]']" ).rules("remove", "required" );
            //$("input[name='data[Business][established]']" ).rules("remove", "required" );
            $(" select[name='data[Business][languages][]']" ).rules("remove", "required" );
            //$("input[name='data[Business][tagline]']" ).rules("remove", "required" );
            $("textarea[name='data[Business][experience]']" ).rules("remove", "required" );
            $("textarea[name='data[Business][education]']" ).rules("remove", "required" );
        }
    }
};

$(document).ready(function() {
    Business.init();
});