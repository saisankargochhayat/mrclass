var map;
var markers = [];
jQuery(document).ready(function($) {
    $('#EventCityId').select2({placeholder: "Select City"}).on("change", function(e) {get_localities($(this).val());});
    $('#EventLocalityId').select2({placeholder: "Select Locality"});
    $('#EventUserId').select2({placeholder: "Select User"});

    if ($("#EventCityId").val() > 0) {
        get_localities($("#EventCityId").val());
    }

});

function set_address(address) {
    var adr = typeof address != 'undefined' && address.trim() != '' ? address.split(',') : new Array();
    var country = adr.pop();
    var state_pin_arr1 = adr.pop();
    var state_pin_arr = typeof state_pin_arr1 != 'undefined' ? state_pin_arr1.trim().split(' ') : new Array();
    var pin = state_pin_arr.pop();
    var state = state_pin_arr.pop();
    var city = adr.pop();
    var locality = adr.pop();
    var addr = adr.join(',');
    typeof pin != 'undefined' && !isNaN(pin) && $('#EventPincode').val() == '' ? $('#EventPincode').val(pin) : '';
    typeof addr != 'undefined' && $('#EventAddress').val().trim() == '' ? $('#EventAddress').val(addr) : '';
}

function geo_search(geocoder, map) {
    var address = ''; //'Bhubaneswar, odisha';
    address += $("#EventAddress").val().trim() != '' ? "" + $("#EventAddress").val().trim() + "," : "";
    address += $("#EventLandmark").val().trim() != '' ? "" + $("#EventLandmark").val().trim() + "," : "";
    address += $("#EventLocalityId").val() > 0 ? "" + $("#EventLocalityId option:selected").html() + "," : "";
    address += $("#EventCityId").val() > 0 ? "" + $("#EventCityId option:selected").html() : "";
    if (address != '') {
        geocodeAddress(geocoder, map, address);
    }
}

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        scrollwheel: false,
        center: {
            lat: 20.2960587,
            lng: 85.82453980000003
        }
    });
    var geocoder = new google.maps.Geocoder();
    setTimeout(function() {
        $("#EventCityId,#EventAddress,#EventLandmark").change(function() {
            geo_search(geocoder, map);
        });
    }, 1000);
}

function geocodeAddress(geocoder, resultsMap, address) {
    geocoder.geocode({
        'address': address
    }, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            setMapOnAll(null);
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: resultsMap,
                draggable: true,
                position: results[0].geometry.location
            });
            google.maps.event.addListener(marker, 'dragend', function(evt) {
                set_latlng(evt.latLng.lat().toFixed(7), evt.latLng.lng().toFixed(7));
                geocodePosition(marker.getPosition());
            });
            markers.push(marker);
            set_address(results[0].formatted_address);
            $('#latitude').val(results[0].geometry.location.lat());
            $('#longitude').val(results[0].geometry.location.lng());
        } else {
            console.log('Geocode was not successful for the following reason: ' + status);
        }
    });
}

function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
    markers = [];
}

function geocodePosition(pos) {
    geocoder = new google.maps.Geocoder();
    geocoder.geocode({
            latLng: pos
        },
        function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                set_address(results[0].formatted_address);
            } else {
                console.log('Cannot determine address at this location.' + status);
            }
        }
    );
}

function set_latlng(lat, lng) {
    $('#latitude').val(lat);
    $('#longitude').val(lng);
}

function get_localities(id){
    var params = {ctid: id};
    $.ajax({
        url: HTTP_ROOT + "content/localities",
        data: params,
        method: 'post',
        success: function(response) {
            $("#EventLocalityId").find('option').remove();
            $("#EventLocalityId").append(response);
            $("#EventLocalityId").val($("#EventLocalityId_tmp").val());
            $("#EventLocalityId").select2('val', $("#EventLocalityId_tmp").val());
        }
    });
}
function validate_event() {
    var validate = $("#event_manage").validate({
        ignore: [],
        rules: {
            'data[Event][user_id]': {required: true},
            'data[Event][name]': {required: true},
            'data[Event][description]': {required: true},
            'data[Event][fee]': {required: "#fee_price:checked",positiveNumber:true},
            'data[Event][custom_end_date]': {required: "#run_daily:checked"},
            'data[Event][event_range]': {required: "#run_specific:checked"},
            'data[Event][city_id]': {required: true},
            'data[Event][locality_id]': {required: true},
            'data[Event][address]': {required: true},
            'data[Event][pincode]': {required: true,digits: true},
            'data[Event][contact_person]': {required: true,noSpecialChars:true},
            'data[Event][phone]': {required: true,moblieNmuber: true},
            'data[Event][email]': {required: true,strictEmail: true},
        },
        messages: {
            'data[Event][user_id]': {required: "Please select an user"},
            'data[Event][name]': {required: "Please enter event name"},
            'data[Event][description]': {required: "Please enter event description"},
            'data[Event][fee]': {required: "Please enter event participation fee"},
            'data[Event][custom_end_date]': {required: "Please select end date for event"},
            'data[Event][event_range]': {required: "Please select event schedule dates"},
            'data[Event][city_id]': {required: "Please select city"},
            'data[Event][locality_id]': {required: "Please select locality"},
            'data[Event][address]': {required: "Please mention the address for the event"},
            "data[Event][pincode]": {required: "Please enter the pincode"},
            "data[Event][contact_person]": {required: "Please enter contact person name"},
            "data[Event][phone]": {required: "Please enter phone number"},
            "data[Event][email]": {required: "Please enter email"}
        },
        errorPlacement: function (error, element) {
            if (element.attr("id") == "EventCityId") {
                error.appendTo($("#EventCityIdErr"));
            } else if (element.attr("id") == "EventLocalityId") {
                error.appendTo($("#EventLocalityIdErr"));
            } else if (element.attr("id") == "EventUserId") {
                error.appendTo($('#EventUserIdError'));
            } else {
                error.insertAfter(element);
            }
        }
    });
    if (validate.valid()) {
        $('#event_manage')[0].submit();
    } else {
        $('input.error,textarea.error').eq(0).focus();
    }
}