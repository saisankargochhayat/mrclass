Search = {
    view: 'grid',
    cid: '',
    sid: '',
    sort: '',
    type: [],
    ctype: [],
    place: [],
    time: [],
    distance: '',
    foodingtype : '',
    sharingtype : '',
    status : '',
    openon: [],
    age_gr: [0, 0],
    gender: '',
    price: '',
    facilities: [],
    hash: '',
    marks: '',
    page: '1',
    reload: 'No',
    city: '',
    lc: '',
    keyword: '',
    init: function() {
        $('.colorbox').colorbox();
        $(document).on('mouseover','.gm-style-mtc',function(){
            $(this).children(':nth-child(1)').is(':visible')?$(this).children(':nth-child(2)').css({'top':'29px'}):"";
        });
        var sflg = true;
        $('#keyword').keydown(function(event){
            var key = window.event ? event.keyCode : event.which; sflg = (key == 13)?true:false;
            if((key == 13 && $('#keyword').val().trim() != '') || sflg === true){Search.change_hash('keyword', $('#keyword').val().trim());}
        });
        $('#classsearchicon').click(function(){
            sflg = ($('#keyword').val().trim() == '')?true:false;
            if(($('#keyword').val().trim() != '') || sflg === true){Search.change_hash('keyword', $('#keyword').val().trim());}
        });
        function autocomplete_url(){return HTTP_ROOT + "content/auto_complete_keyword?cid="+$("#BusinessCategoryId").val();}
        $("#keyword").autocomplete({serviceUrl: autocomplete_url,minLength: 1,onSelect: function(suggestion) {$("#keyword").val(suggestion.data);setTimeout(function(){$('#classsearchicon').trigger('click');},200);}});

        $('#togglemap').click(function(){
            $('#map').height() > 200
            ? $('#map').animate({height:"75px"},500,function(){Search.resize_map('done');$('.togglemapicon').removeClass('fa-compress').addClass('fa-expand').attr('title','Expand Map');$('.text-f-map').show();infowindow.close();})
            : $('#map').animate({height:"400px"},500,function(){Search.resize_map('done');$('.togglemapicon').removeClass('fa-expand').addClass('fa-compress').attr('title','Reduce Map');$('.text-f-map').hide();var zoomOverride=map.getZoom();if(zoomOverride<9){zoomOverride=9;}map.setZoom(zoomOverride);});
        });

        $(document).on('click','.jcarousel-control-prev',function() {$(this).closest('.jcarousel-wrapper').find('.jcarousel').jcarousel('scroll', '-=1');});
        $(document).on('click','.jcarousel-control-next',function() {$(this).closest('.jcarousel-wrapper').find('.jcarousel').jcarousel('scroll', '+=1');});
        this.reset('value');
        var tooltip = $('<div>').attr({'class': 'ui-slider-handle-tooltip'});
        $("#distance_slider").slider({range: 'min',min: 0,max: 500,value: 75,
            create: function(event, ui) {$("#distance").html("75 Km");},
            slide: function(event, ui) {$("#distance").html("" + ui.value + " Km");$(ui.handle).find('.ui-slider-handle-tooltip').text(ui.value + ' km');},
            start: function(event, ui) {$(ui.handle).find('.ui-slider-handle-tooltip').show();},
            stop: function(event, ui) {$(ui.handle).find('.ui-slider-handle-tooltip').hide();Search.change_hash('distance', ui.value);}
        }).find(".ui-slider-handle").append(tooltip);
        //console.log($("#distance_slider").find(".ui-slider-handle"));

        $("#price_slider").slider({range: true,min: 0,max: 500,values: [75, 300],
            create: function(event, ui) {$("#amount").html("Rs.75 - Rs.300");},
            slide: function(event, ui) {$("#amount").html("Rs." + ui.values[0] + " - Rs." + ui.values[1]);$(ui.handle).find('.ui-slider-handle-tooltip').text('Rs.' + ui.value + '');},
            start: function(event, ui) {$(ui.handle).find('.ui-slider-handle-tooltip').show();},
            stop: function(event, ui) {Search.change_hash('price', ui.values[0] + "-" + ui.values[1]);$(ui.handle).find('.ui-slider-handle-tooltip').hide();}
        }).find(".ui-slider-handle").append(tooltip);

        /*hash change*/
        $(window).bind('hashchange', function() {Search.load();});
        /*window scroll event*/
        $(window).scroll(function() {scrolltoloadrecord($("#load_more_record"));});

        $(".filterblocks").on('change', 'input,select', function() {
            if ($('#content_loader').is(':visible')) {
                return false;
            }
            General.hideAlert('now');
            $id = $(this).attr('id');
            if($id == 'time_start' || $id == 'time_to'){
                if($('#time_start').val()!='' && $('#time_to').val()!=''){
                    $of_start = $('#time_start').val().replace(/[0-9]+/,'');
                    $t_start = parseInt($('#time_start').val().replace(/[a-zA-Z]+/,''));
                    $t_start = $t_start == 12 && $of_start == 'am' ? 0 : ($of_start == 'am' ? $t_start : 12+parseInt($t_start == 12 && $of_start == 'pm' ? 0 : $t_start));

                    $of_to = $('#time_to').val().replace(/[0-9]+/,'');
                    $t_to = $('#time_to').val().replace(/[a-zA-Z]+/,'');
                    $t_to = $t_to == 12 && $of_to == 'am' ? 0 : ($of_to == 'am' ? $t_to : 12+parseInt($t_to == 12 && $of_to == 'pm' ? 0 : $t_to));

                    var flag = (parseInt($t_start) < parseInt($t_to));

                    if(!flag){
                        alert($id == 'time_start' ? "Start time should be less than end time" : "End time should be more than start time","error");
                        General.hideAlert();
                        return false;
                    }
                }
            }else if($id == 'age_min' || $id == 'age_max'){
                $age_min = parseInt($('#age_min').val());
                $age_max = parseInt($('#age_max').val());
                if($age_min > 0 && $age_max > 0 && $age_min >= $age_max){
                    alert($id == 'age_min' ? "Min age should be less than max age" : "Max age should be more than min age","error");
                    General.hideAlert();
                    return false;
                }
            }

            if ($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox') {
                Search.change_hash($(this).closest(".filterblocks").attr('data-ftype'), $(this).val());
            } else {
                Search.change_hash($(this).attr('id'), $(this).val());
            }
        }).on('click', 'a', function() {
            if ($('#content_loader').is(':visible')) {
                return false;
            }
            $(this).closest(".lft_poplty_cnt").find('a').removeClass('active');
            $(this).addClass('active');
            Search.change_hash($(this).closest(".filterblocks").attr('data-ftype'), $(this).attr('data-mode'));
        });
        $(".toggle-arrow").click(function() {
            $(this).closest('.filterblocks').find('.toggle-block').slideToggle();
            $(this).toggleClass('uparrow downarrow')
            //$(this).hasClass('uparrow') ? $(this).removeClass('uparrow').addClass('downarrow') : $(this).addClass('uparrow').removeClass('downarrow');
        });
        $(".viewblockstoggle").click(function() {
            if ($('#content_loader').is(':visible')) {
                return false;
            }

            $(".viewblockstoggle").removeClass('active');
            $(this).addClass('active');
            $(".viewblocks").hide();
            $("#" + $(this).attr('data-view') + 'viewblock').show();
            Search.change_hash('view', $(this).attr('data-view'));
            //Search.view = $(this).attr('data-view');
            //Search.load();
        });
        $("#BusinessSubcategoryId").change(function() {
            if ($('#content_loader').is(':visible')) {
                return false;
            }
            Search.change_hash('sid', $(this).val());
            //Search.sid = $(this).val();
            //Search.load();
        });
        $("#BusinessCategoryId").change(function() {
            if ($('#content_loader').is(':visible')) {return false;}
            var cid = $(this).val();
            //Search.reset('all');
            //Search.load_categories();
            Search.change_hash('cid', cid);
            //Search.change_hash('sid', '');
            //Search.cid = $(this).val();
            //Search.load();
        });
        $(".categorylist").find('a').on('click', function (event) {if (typeof $(this).attr('href') !== 'undefined') {event.stopPropagation();event.preventDefault();if ($('#content_loader').is(':visible')) {return false;}var cival = $(this).attr('href');var cid = cival.substr(cival.indexOf('#') + 1);Search.change_hash('cid', cid.substr(cid.indexOf('=') + 1));}});
        this.hash = typeof window.location.hash != 'undefined' ? window.location.hash.replace('#', '') : "";
        if (this.hash != '') {
            Search.change_hash('page', '');
            Search.reload = 'Yes';
            Search.set_hash();
            //Search.load_categories();
        }
        Search.load();
    },
    load: function() {

        if ($('#content_loader').is(':visible')) {
            return false;
        }
        $('#content_loader').show();
        var hash = typeof window.location.hash != 'undefined' ? window.location.hash.replace('#', '') : "";
        Search.set_hash();
        console.log(Search);
        var params = {
            view: Search.view,
            cid: Search.cid,
            sid: Search.sid,
            page: Search.page,
            sort: Search.sort,
            type: Search.type,
            ctype: Search.ctype,
            place: Search.place,
            time: Search.time,
            distance: Search.distance,
            foodingtype:Search.foodingtype,
            sharingtype:Search.sharingtype,
            status:Search.status,
            openon: Search.openon,
            age_gr: Search.age_gr,
            gender: Search.gender,
            price: Search.price,
            facilities: Search.facilities,
            reload: Search.reload,
            lc: Search.lc,
            city: Search.city,
            keyword: Search.keyword,
        };

        //$('#content_loader').hide();
        //console.log(params);
        //return false;
        $.ajax({
            url: HTTP_ROOT + "content/ajax_search",
            data: params,
            method: 'post',
            //dataType: 'json',
            success: function(response) {
                var _animated_css = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";
                if (params.page > 1) {
                    $('#content_box').append(response);
                } else {
                    $('#content_box').html(response);
                }
                $('#content_loader').hide();
                if(Search.view == 'list'){
                    $('.jcarousel').jcarousel();
                    $('.colorbox').colorbox();
                }
                if (typeof mark_points != 'undefined' && mark_points != '') {
                    Search.marks = $.parseJSON(mark_points);
                    if (typeof map != 'undefined') {
                        Search.set_markers(Search.marks);
                    }
                }
                $("#load_more_record").click(function() {
                    $(this).remove();
                    var page = Math.floor($('.viewitems').size() / BUSINESS_SEARCH_PAGE_LIMIT);
                    Search.change_hash('page', page + 1);
                });

                if (typeof max_distance != 'undefined' && max_distance != '') {
                    var distance = params.distance > 0 ? params.distance : max_distance;
                    $('#distance_slider').slider({max: max_distance, value: distance});
                    $('#distance').html(Math.round(distance)+' Km');

                    $price = params.price.split('-')
                    var min_price_v1 = $price[0] || min_price;
                    var max_price_v1 = $price[1] || max_price;
                    $('#price_slider').slider('option', 'min', Math.round(min_price));
                    $('#price_slider').slider('option', 'max', Math.round(max_price));

                    $("#price_slider").slider('option', 'values', [Math.round(min_price_v1), Math.round(max_price_v1)]);
                    //$("#price_slider").slider('values',1,max_price);
                    //$("#price_slider").slider("refresh");
                    //console.log(Math.round(min_price)+' - Rs.'+Math.round(max_price))
                    $('#amount').html('Rs.' + (params.price != "" ? params.price.replace('-', ' - Rs.'):Math.round(min_price_v1)+' - Rs.'+Math.round(max_price)));
                }
                if (typeof facilities != 'undefined' && facilities != '') {
                    var tmp = [];
                    var hfacility = Search.get_hash('facilities');
                    Search.facilities = hfacility!=''?hfacility.split('-'):[];
                    //console.log(Search.facilities);
                    //console.log(facilities);
                    $.each($.parseJSON(facilities), function(key, val) {
                        tmp.push({v: val, k: key});
                    });

                    tmp.sort(function(a, b) {
                        return (a.v > b.v) ? 1 : ((a.v < b.v) ? -1 : 0);
                    });
                    //if(a.v > b.v){ return 1}if(a.v < b.v){ return -1}return 0;

                    $el = $('#biz_facilities').find('.jspPane').length>0?$('#biz_facilities').find('.jspPane'):$('#biz_facilities');
                    $el.html('');

                    $.each(tmp, function(key1, val1) {
                        var key = val1.k;
                        var val = val1.v;
                        $el.append($('<li>').html($('<label>').attr('for', 'facilities_' + key).html($("<input/>").attr({'type': 'checkbox', 'id': 'facilities_' + key, 'value': key, 'checked': jQuery.inArray(key, Search.facilities) > -1})).append('&nbsp;' + val)));
                    });
                    setTimeout(function(){
                        $('#biz_facilities').jScrollPane();
                    },500);
                }
                $("img.lazy").lazyload({effect : "fadeIn"}).removeClass("lazy");
                var anime_class = (Search.view == 'list') ? 'effects_list' : 'effects_grid';
                $('#content_box').find("."+anime_class).addClass('animated zoomIn').one(_animated_css, function () {
                    $('#content_box').find("."+anime_class).removeClass('animated zoomIn '+anime_class);
                });
            }
        });
    },
    set_hash: function() {
        var hash = typeof window.location.hash != 'undefined' ? window.location.hash.replace('#', '') : "";
        $hash = hash.split('|');
        Search.age_gr = [];
        Search.facilities = [];
        this.reset('reset');
        $.each($hash, function(key, val) {
            if (val.trim() != '') {
                $val = val.split('=');
                var def_selected = new Array();
                //console.log($val[0])
                switch ($val[0]) {
                    case 'cid' :
                        Search.cid = $val[1];
                        $("#BusinessCategoryId").val($val[1]);
                        break;
                    case 'sid' :
                        Search.sid = $val[1];
                        $("#BusinessSubcategoryId").val($val[1]).attr('data-val',$val[1]);
                        break;
                    case 'view' :
                        Search.view = $val[1];
                        $('.viewblockstoggle').removeClass('active');
                        $('.' + Search.view + '_view').addClass('active');
                        break;
                    case 'page' :
                        Search.page = $val[1];
                        break;
                    case 'sort' :
                        Search.sort = $val[1];
                        $('#filterblocks_sort_items').find('a').each(function(){if($(this).attr('data-mode')==$val[1]) $(this).addClass('active');});
                        break;
                    case 'type' :
                        Search.type = $val[1];
                        break;
                    case 'city' :
                        Search.city = $val[1];
                        break;
                    case 'lc' :
                        Search.lc = $val[1];
                        break;
                    case 'place' :
                        if ($val[1] != '') {
                            def_selected = $val[1].split('-');
                            $.each(def_selected, function(key, val) {
                                $("#place_" + val).attr('checked', 'checked');
                            })
                        }
                        Search.place = [];
                        $('#filterblocks_place').find('input[type=checkbox]:checked').each(function() {
                            Search.place.push($(this).val());
                        });
                        //Search.place = $val[1];
                        break;
                    case 'ctype' :
                        if ($val[1] != '') {
                            def_selected = $val[1].split('-');
                            $.each(def_selected, function(key, val) {
                                $("#ctype_" + val).attr('checked', 'checked');
                            })
                        }
                        Search.ctype = [];
                        $('#filterblocks_ctype').find('input[type=checkbox]:checked').each(function() {
                            Search.ctype.push($(this).val());
                        });
                        //Search.place = $val[1];
                        break;
                    case 'time' :
                        //console.log($val[1]);
                        //Search.time = $val[1];
                        break;
                    case 'time_start' :
                        $('#time_start').val($val[1]);
                        Search.time[0] = $val[1];
                        break;
                    case 'time_to' :
                        $('#time_to').val($val[1]);
                        Search.time[1] = $val[1];
                        break;
                    case 'distance' :
                        Search.distance = $val[1];
                        break;
                    case 'openon' :
                        //Search.openon = $val[1];
                        Search.openon = [];
                        if ($val[1] != '') {
                            def_selected = $val[1].split('-');
                            $.each(def_selected, function(key, val) {
                                $("#openon_" + val).attr('checked', 'checked');
                                Search.openon.push(val);
                            })
                        }
                        /*$('#filterblocks_openon').find('input[type=checkbox]:checked').each(function() {});*/
                        break;
                        //case 'age_gr' :
                    case 'age_min' :
                        $('#age_min').val($val[1]);
                        Search.age_gr[0] = $val[1];
                        break;
                    case 'age_max' :
                        $('#age_max').val($val[1]);
                        Search.age_gr[1] = $val[1];
                        break;
                    case 'gender' :
                        $('#gender_' + $val[1]).attr('checked', 'checked');
                        Search.gender = $val[1];
                        break;
                    case 'price' :
                        Search.price = $val[1];
                        break;
                    case 'keyword' :
                        $('#keyword').val(decodeURIComponent($val[1].replace(/[\+]+/g,' ')));
                        Search.keyword = $val[1];
                        break;
                    case 'facilities' :
                        Search.facilities = [];
                        if ($val[1] != '') {
                            def_selected = $val[1].split('-');
                            $.each(def_selected, function(key, val) {
                                $("#facilities_" + val).attr('checked', 'checked');
                                //Search.facilities.push(val);
                            })
                        }
                        $('#filterblocks_facilities').find('input[type=checkbox]:checked').each(function(){
                            Search.facilities.push($(this).val());
                        });
                        break;
                }
            }
        });
        //console.log($("#ctype_private").is(':checked'))
        $("#ctype_private").is(':checked')?$("#filterblocks_place").show():$("#filterblocks_place").hide();
        $("#ctype_private").is(':checked')?"":Search.place = [];
    },
    get_hash: function(item) {
        var hash = typeof window.location.hash != 'undefined' ? window.location.hash.replace('#', '') : "";
        $hash = hash.split('|');
        $val = [];
        $.each($hash, function(key, val) {
            if (val.trim() != '') {
                $val = val.split('=');
                if ($val[0] == item) {
                    return false;
                }
            }
        });
        return typeof $val[1] != 'undefined' && $val[0] == item ? $val[1] : '';
    },
    load_categories: function() {
        var params = {catid: $("#BusinessCategoryId").val()};
        $.ajax({
            url: HTTP_ROOT + "content/subcats",
            data: params,
            method: 'post',
            success: function(response) {
                $("#BusinessSubcategoryId").find('option:gt(0)').remove();
                $("#BusinessSubcategoryId").append(response);
                $("#BusinessSubcategoryId").val($("#BusinessSubcategoryId").attr('data-val'));
                //$('#BusinessSubcategoryId').trigger('change');
            }
        });
    },
    change_hash: function(opt, data, id) {
        //console.log(opt+" >> "+ data+" >> "+ id);
        if(opt=='keyword'){
            //data = data.split(' ').join('+');
            data = data.replace(/[\+]+/g,'%2B');
            data = data.replace(/[\s]+/g,'+');
        }
        var hash = typeof window.location.hash != 'undefined' ? window.location.hash.replace('#', '') : "";
        $hash = hash.split('|');
        var new_hash = new Array();
        var _temp = new Array();
        var found = false;
        var m_arr = ['place', 'facilities', 'openon', 'ctype'];

        //console.log($.inArray('ctype=private',$hash));
        console.log($hash);
        $.each($hash, function(key, val) {
            $val = val.split('=');
            console.log($val);
            if ($val[0] !== 'page' && $val[0] != '') {
                if ($val[0] === opt) {
                    found = true;
                    if (jQuery.inArray(opt, m_arr) > -1) {
                        $('#filterblocks_' + opt).find('input[type=checkbox]:checked').each(function() {
                            _temp.push($(this).val());
                        });
                        if (_temp.length > 0)
                            new_hash.push($val[0] + "=" + _temp.join('-'));
                    } else if (data != '') {
                        new_hash.push($val[0] + "=" + data);
                    }
                } else if(typeof $val[1] != 'undefined' && $val[1] != ''){
                    new_hash.push(val);
                }
            }

        });
        if($.inArray('ctype=private',new_hash) > -1 || $.inArray('ctype=private-group',new_hash) > -1){}else{
            //console.log($hash);
            var tmpkey = $.inArray('place=home',new_hash) > -1?"place=home":($.inArray('place=trainer',new_hash) > -1?"place=trainer":"place=home-trainer");
            new_hash.remove(tmpkey);
            $('#filterblocks_place').find('input[type=checkbox]').attr('checked',false);
        }
        //console.log(new_hash);
        if (!found && data != '') {
            new_hash.push(opt + "=" + data);
        }

        //console.log(new_hash)
        Search.page = 1;
        //new_hash.push("page=1");
        window.location.hash = new_hash.join('|');
    },
    set_markers: function(marks,setcluster) {
        var setcluster = setcluster || '';
        //console.log(Search.page+' == 1 || '+Search.reload+' === Yes')
        if (Search.page == 1 || Search.reload === 'Yes') {
            //console.log(markers)
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
            cluster = [];
            // Create a new LatLngBounds object

            markerBounds = typeof google.maps.LatLngBounds != 'undefined' ? new google.maps.LatLngBounds() : '';
            //console.log(markerClusterer)
            if (typeof markerClusterer == 'object' && $.trim(markerClusterer) !='') {
                markerClusterer.clearMarkers();
                //markerClusterer.redraw();
            }
        }

        Search.reload = 'No';
        //deleteMarkers();
        //setMapOnAll(null);
        $.each(marks, function(key, val) {
            var name = val.name;
            var address = val.address;
            var logo = val.logo;
            var link = val.link;
            //var type = markers[i].getAttribute("type");

            var offsetLat = val.latitude * (Math.random() * (max - min) + min);
            var offsetLng = val.longitude * (Math.random() * (max - min) + min);

            var point = typeof google.maps.LatLng != 'undefined' ? new google.maps.LatLng(offsetLat, offsetLng) : "";
            var html = "<b>" + name + "</b> <br/>" + address;
            var icon = customIcons.def;
            marker = typeof google.maps.Marker != 'undefined' ? new google.maps.Marker({
                map: map,
                position: point,
                icon: icon.icon,
                shadow: icon.shadow,
                animation: typeof google.maps.Animation != 'undefined' ? google.maps.Animation.DROP : ''
            }) : "";
            if(marker != ''){
                //google.maps.event.addListener(marker, 'click', (function(marker) {
                google.maps.event.addListener(marker, 'mouseover', (function(marker) {
                    var content = '<div class="newinfo"><img src="' + logo + '" alt="" height="100" width="100"/>';
                    content += '<div class="icont"><b style="font-size:16px;">' + name + '</b>';
                    content += '<p class="addr">' + address + '</p>';
                    content += '<div class="rmore"><a href="' + link + '" target="_blank">Read More ></a></div>';
                    content += '</div></div>';
                    return function() {
                        if(!$('.togglemapicon').hasClass('fa-expand')){
                            infowindow.setContent(content);
                            infowindow.open(map, marker);
                        }
                    }
                })(marker));
                /*google.maps.event.addListener(marker, 'mouseout', (function(marker,content,infowindow){
                    return function() {
                       infowindow.close();
                    };
                })(marker,content,infowindow)); */
                markers.push(marker);
                cluster.push(marker);
                if(markerBounds) markerBounds.extend(point);
            }
        });
        if(setcluster!='no'){
            if(typeof marker == 'undefined' || marker == ''){ return false;}
            // Then you just call the fitBounds method and the Maps widget does all rest.
            //alert(setcluster)

            if(setcluster!='reset'){
                if(markerBounds) map.fitBounds(markerBounds);
                /*restrict max zoom level*/
                var zoomOverride=map.getZoom();
                if(zoomOverride>17){zoomOverride=17;}
                map.setZoom(zoomOverride);
                /*end*/
            }
            //console.log(cluster)
            //console.log(typeof markerClusterer)
            markerClusterer =  new MarkerClusterer(map, cluster);
            google.maps.event.addListener(markerClusterer, "mouseover", function(c) {
                $(c.clusterIcon_.div_).effect('bounce', {times: 2}, 'slow');
            });

        google.maps.event.addListener(infowindow, 'domready', function() {

            // Reference to the DIV that wraps the bottom of infowindow
            var iwOuter = $('.gm-style-iw');
            //iwOuter.parent('div').css('background','#fff');
            /* Since this div is in a position prior to .gm-div style-iw.
             * We use jQuery and create a iwBackground variable,
             * and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
             */
            var iwBackground = iwOuter.prev();

            // Removes background shadow DIV
            iwBackground.children(':nth-child(2)').css({'display': 'none'});

            // Removes white background DIV
            iwBackground.children(':nth-child(4)').css({'display': 'none'});

            // infobox design
            //iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index' : '1','background':'rgb(238, 121, 69)'});
            iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'background':'rgb(238, 121, 69)'});

            // Moves the infowindow 115px to the right.
            // Reference to the div that groups the close button elements.
            var iwCloseBtn = iwOuter.next();

            // Apply the desired effect to the close button
            iwCloseBtn.css({opacity: '1', right: '33px', top: '3px',  'box-shadow': '0 0 5px #3990B9'});

            // If the content of infowindow not exceed the set maximum height, then the gradient is removed.
            if ($('.iw-content').height() < 140) {
                $('.iw-bottom-gradient').css({display: 'none'});
            }

            // The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
            iwCloseBtn.mouseout(function() {
                $(this).css({opacity: '1'});
            });
        });
         }
    },
    reset: function(mode) {
        var view = Search.get_hash('view');
        mode = mode || '';
        //this.view = 'grid';
        this.view = view!=''?view:'grid';
        this.cid = '';
        this.sid = '';
        this.sort = '';
        this.type = [];
        this.ctype = [];
        this.place = [];
        this.time = [];
        this.distance = '';
        this.openon = [];
        this.age_gr = [0, 0];
        this.gender = '';
        this.price = '';
        this.facilities = [];
        this.hash = '';
        this.marks = '';
        this.city = '';
        this.lc = '';
        this.page = '1';
        this.reload = 'No';
        this.keyword = '';
        if(mode == 'all'){
            $('#keyword').val('');
            $('#BusinessCategoryId').val('');
            $('#age_min,#age_max').val('');
            $('#time_start,#time_to').val('');
            $('#filterblocks_sort_items').find('a').removeClass('active');
            $('#filterblocks_sort_items').find('a:eq(0)').addClass('active');
            $('#filterblocks_ctype').find('input[type="checkbox"]').attr('checked',false);
            $('#filterblocks_place').find('input[type="checkbox"]').attr('checked',false);
            $('#filterblocks_openon').find('input[type="checkbox"]').attr('checked',false);
            $('#filterblocks_facilities').find('input[type="checkbox"]').attr('checked',false);
            $('#filterblocks_gender').find('input[type="radio"]').attr('checked',false);
            $('.viewblockstoggle').removeClass('active');
            $('.' + Search.view + '_view').addClass('active');
        }
        if(mode == 'value' || mode == 'all'){
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
            cluster = [];
            //console.log(markerClusterer)
            if (typeof markerClusterer == 'object' && $.trim(markerClusterer) !='') {
                markerClusterer.clearMarkers();
            }
        }
        if(mode == 'all'){
            window.location.hash = '';
            Search.change_hash('view', Search.view);
            $('.' + Search.view + '_view').addClass('active');
        }
    },
    resize_map:function(){
        var center = map.getCenter();
        google.maps.event.trigger(map, "resize");
        map.setCenter(center);
    },
    clearMarkers:function(){
        if(typeof markers != 'undefined' && markers.length > 0){
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
        }
        if (typeof markerClusterer == 'object' && $.trim(markerClusterer) !='') {
            markerClusterer.clearMarkers();
        }
        map.setZoom(9);
        map.setCenter(new google.maps.LatLng(20.3156929, 85.8547923));
        $('#map').height() > 200 ?
            $('#map').animate({height:"150px"},500,function(){
                Search.resize_map('done');
                $('.togglemapicon').removeClass('fa-compress').addClass('fa-expand').attr('title','Expand Map');
                $('.text-f-map').show();
                infowindow.close();
            }):"";
    },
    resetClusters:function(mode){
        var mode = mode || '';
        if (typeof markerClusterer == 'object' && markerClusterer != null){
            if(mode == 'hide'){
                markerClusterer.setMap(null);
            }else{
                markerClusterer.setMap(map);
            }
        }
        //Search.set_markers(Search.marks,'no');
        //Search.set_markers(Search.marks,'reset');
    }
};
jQuery(document).ready(function() {
    Search.init();
});
Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};
