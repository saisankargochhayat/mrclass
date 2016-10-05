<link href="<?php echo HTTP_ROOT; ?>css/effect.css" rel="stylesheet" />
<?php echo $this->Html->script('jquery.lazyload.min', array('block' => 'lazyLoad'));?>
<style type="text/css">
    #map{height: 75px; background-image: none; }
    .map-x{ position: absolute; left:46%; top:0px;}
    .map-x a.togglemap{background: #014D99; color: #fff; text-align: center; padding-top: 4px; border-radius: 25%; height: 24px; width: 35px;position:relative}
    .togglemap i{display: block; font-size: 15px;}
    .text-f-map{font-size: 13px;left: 50%;margin-left: -137px;position: absolute;top: 2px;}
    .time_list.age_grp div select{width: 32%;}
    .ui-autocomplete-loading {background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;}
    @media only screen and (max-width:420px){
      #map{ overflow: hidden  !important;width:360px !important; }
      .srh_list_mc .rt_det_mc .top_sch_map .srch_frm_list {left: 37px;}
    }
    @media only screen and (max-width:340px){
      #map{width:309px !important;}
      .srh_list_mc .rt_det_mc .top_sch_map .srch_frm_list {left: 10px;}
    }
</style>
<?php
echo $this->Html->script('jquery.autocomplete', array('inline' => false));
echo $this->Html->script(array('jquery.jcarousel.min','jcarousel.responsive'), array('inline' => false));
echo $this->Html->script('search', array('inline' => false));
echo $this->Html->script('https://maps.googleapis.com/maps/api/js?key='.GOOGLE_MAP_KEY .'&libraries=places&callback=initMap', array('inline' => false));
#echo $this->Html->script('https://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclustererplus/src/markerclusterer.js', array('inline' => false));
echo $this->Html->script('markerclusterer', array('inline' => false));
?>

<div class="srh_list_mc">
    <div class="wrapper">
        <div class="fl lft_det_mc" id="business_filters">
            <div class="top_m_ttl"><h2>FILTERS <a class="reset-icon anchor" onclick="Search.reset('all');Search.load();">CLEAR</a></h2></div>
            <div class="filter-icon-mobile"></div>
            <div class="mobile-view-filter">
            <div class="filterblocks" id="filterblocks_sort" data-ftype="sort">
                <div class="lft_ttl_cnt"><h3>Sort By<span class="toggle-arrow uparrow"></span></h3></div>
                <div class="lft_poplty_cnt toggle-block" id="filterblocks_sort_items">
                    <h6><a data-mode="popularity" class="anchor active">Popularity</a></h6>
                    <h6><a data-mode="price-high-to-low" class="anchor">Price: High to Low</a></h6>
                    <h6><a data-mode="price-low-to-high" class="anchor">Price: Low to High</a></h6>
                    <h6><a data-mode="rate-high-to-low" class="anchor">Ratings: High to Low</a></h6>
                    <h6><a data-mode="rate-low-to-high" class="anchor">Ratings: Low to High</a></h6>
                </div>
            </div>
            <div class="filterblocks" data-ftype="sharingtype">
                <div class="lft_ttl_cnt"><h3>Number of sharing<span class="toggle-arrow uparrow"></span></h3></div>
                <div class="class_type toggle-block">
                    <div>
                      <label><input type="radio" name="sharing" id="sharing_single" value="single"/>&nbsp;Single</label>
                      <label><input type="radio" name="sharing" id="sharing_double" value="double"/>&nbsp;Double</label>
                      <label><input type="radio" name="sharing" id="sharing_triple" value="triple"/>&nbsp;Triple</label>
                      <label><input type="radio" name="sharing" id="sharing_more" value="more"/>&nbsp;More</label>
                    </div>
                </div>
            </div>
            <div class="filterblocks" data-ftype="foodingtype">
                <div class="lft_ttl_cnt"><h3>Fooding<span class="toggle-arrow uparrow"></span></h3></div>
                <div class="class_type toggle-block">
                    <div>
                      <label><input type="radio" name="fooding" id="fooding_food" value="food"/>&nbsp;Food</label>
                      <label><input type="radio" name="fooding" id="fooding_nofood" value="nofood"/>&nbsp;No Food</label>
                    </div>
                </div>
            </div>
            <div class="filterblocks" data-ftype="status">
                <div class="lft_ttl_cnt"><h3>Status<span class="toggle-arrow uparrow"></span></h3></div>
                <div class="class_type toggle-block">
                    <div>
                      <label><input type="radio" name="status" id="status_furnished" value="furnished"/>&nbsp;Furnished</label><br>
                      <label><input type="radio" name="status" id="status_semifurnished" value="semifurnished"/>&nbsp;Semi-Furnished</label><br>
                      <label><input type="radio" name="status" id="status_nonfurnished" value="nonfurnished"/>&nbsp;Non-Furnished</label>
                    </div>
                </div>
            </div>
            <div class="filterblocks" id="filterblocks_ctype" data-ftype="ctype">
                <div class="lft_ttl_cnt"><h3>Class Type<span class="toggle-arrow uparrow"></span></h3></div>
                <div class="class_type toggle-block">
                    <div>
                        <label for="ctype_private" class="w50"><input type="checkbox" id="ctype_private" value="private"/>&nbsp;Private</label>
                        <label for="ctype_group" class="w50"><input type="checkbox" id="ctype_group" value="group"/>&nbsp;Group</label>
                    </div>
                </div>
            </div>
            <div class="filterblocks" id="filterblocks_place" data-ftype="place">
                <div class="lft_ttl_cnt"><h3>Place&nbsp;<i class="ion ion-information-circled none" style="color:#333;" title="Only for Private classes"></i><span class="toggle-arrow uparrow"></span></h3></div>
                <div class="class_type toggle-block">
                    <div>
                        <label for="place_home" class="w50"><input type="checkbox" id="place_home" value="home"/>&nbsp;Your Home</label>
                        <label for="place_trainer" class="w50"><input type="checkbox" id="place_trainer" value="trainer" />&nbsp;Trainer's Place</label>
                    </div>
                </div>
            </div>
            <div class="filterblocks" id="filterblocks_time" data-ftype="time">
                <div class="lft_ttl_cnt"><h3>Time<span class="toggle-arrow uparrow"></span></h3></div>
                <div class="time_list toggle-block">
                    <div>
                        <select id="time_start">
                            <option value="">Start Time</option>
                            <?php for($i=0;$i<24;$i++){?>
                                <?php $time = $i<12 ? ($i==0 ? 12 : $i)."am" : ($i==12 ? $i : $i-12)."pm";?>
                                <option value="<?php echo $time;?>"><?php echo $time;?></option>
                            <?php }?>

                        </select>
                        <span>To</span>
                        <select id="time_to">
                            <option value="">End Time</option>
                            <?php for($i=0;$i<24;$i++){?>
                                <?php $time = $i<11 ? ($i+1)."am" : ($i==11 ? $i+1 : $i-12+1)."pm";?>
                                <option value="<?php echo $time;?>"><?php echo $time;?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="filterblocks" id="filterblocks_distance" data-ftype="distance">
                <div class="lft_ttl_cnt"><h3>Distance<span class="toggle-arrow uparrow"></span></h3></div>
                <div class="dist_lst toggle-block">
                    <div>
                        <div id="distance_slider"></div>
                        <div id="distance"></div>
                    </div>
                </div>
            </div>
            <div class="filterblocks" id="filterblocks_openon" data-ftype="openon">
                <div class="lft_ttl_cnt"><h3>Open On<span class="toggle-arrow uparrow"></span></h3></div>
                <div class="open_onlg toggle-block">
                    <div>
                        <ul class="fl">
                            <li><label for="openon_mon"><input type="checkbox" id="openon_mon" value="mon"/>&nbsp;Monday</label></li>
                            <li><label for="openon_wed"><input type="checkbox" id="openon_wed" value="wed"/>&nbsp;Wednesday</label></li>
                            <li><label for="openon_fri"><input type="checkbox" id="openon_fri" value="fri"/>&nbsp;Friday</label></li>
                            <li><label for="openon_sun"><input type="checkbox" id="openon_sun" value="sun"/>&nbsp;Sunday</label></li>
                        </ul>
                        <ul class="fr">
                            <li><label for="openon_tue"><input type="checkbox" id="openon_tue" value="tue"/>&nbsp;Tuesday</label></li>
                            <li><label for="openon_thu"><input type="checkbox" id="openon_thu" value="thu"/>&nbsp;Thursday</label></li>
                            <li><label for="openon_sat"><input type="checkbox" id="openon_sat" value="sat"/>&nbsp;Saturday</label></li>
                        </ul>
                        <div class="cb"></div>
                    </div>
                </div>
            </div>
            <div class="filterblocks" id="filterblocks_age" data-ftype="age">
                <div class="lft_ttl_cnt"><h3>Age Group<span class="toggle-arrow uparrow"></span></h3></div>
                <div class="time_list age_grp toggle-block">
                    <div>
                        <select id="age_min">
                            <option value="">Min Age</option>
                            <?php for($age=1;$age<100;$age++){?>
                                <option value="<?php echo $age;?>"><?php echo $age;?></option>
                            <?php }?>
                        </select>
                        <span>To</span>
                        <select id="age_max">
                            <option value="">Max Age</option>
                            <?php for($age=1;$age<100;$age++){?>
                                <option value="<?php echo $age;?>"><?php echo $age;?></option>
                            <?php }?>
                        </select>
                        <span class="lst">yrs</span>
                    </div>
                </div>
            </div>
            <div class="filterblocks" id="filterblocks_gender" data-ftype="gender">
                <div class="lft_ttl_cnt"><h3>Gender<span class="toggle-arrow uparrow"></span></h3></div>
                <div class="gender_lst toggle-block">
                    <div>
                        <label><input type="radio" name="gender" id="gender_both" value="both"/>&nbsp;Both</label>
                        <label><input type="radio" name="gender" id="gender_male" value="male"/>&nbsp;Male</label>
                        <label><input type="radio" name="gender" id="gender_female" value="female"/>&nbsp;Female</label>
                    </div>
                </div>
            </div>
            <div class="filterblocks" id="filterblocks_price" data-ftype="price">
                <div class="lft_ttl_cnt"><h3>Price Range<span class="toggle-arrow uparrow"></span></h3></div>
                <div class="dist_lst p_range toggle-block">
                    <div>
                        <div id="price_slider"></div>
                        <div id="amount"></div>
                    </div>
                </div>
            </div>
            <div class="filterblocks" id="filterblocks_facilities" data-ftype="facilities">
                <div class="lft_ttl_cnt"><h3>Facilities<span class="toggle-arrow uparrow"></span></h3></div>
                <div class="fac_list toggle-block">
                    <ul id="biz_facilities">
                        <?php if(!empty($facilities) && is_array($facilities) && count($facilities)>0){?>
                            <?php foreach($facilities as $key => $val){?>
                                <li>
                                    <label for="facilities_<?php echo $key;?>"><input type="checkbox" id="facilities_<?php echo $key;?>" value="<?php echo $key;?>"/>&nbsp;<?php echo $val;?></label>
                                </li>
                            <?php }?>
                        <?php }?>
                    </ul>
                </div>
            </div>
            </div>
        </div>

        <div class="fl rt_det_mc relative">
            <div id="map"></div>
            <div class="top_sch_map" >
                <div class="srch_frm_list">
                    <div class="cent_frm">
                        <select class="fl" id="BusinessCategoryId">
                            <option value="">Choose a Category</option>
                            <?php if (!empty($topcategories) && is_array($topcategories)) { ?>
                                <?php foreach ($topcategories as $key => $cat) { ?>
                                    <option value="<?php echo h($key); ?>"><?php echo h($cat); ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                        <input type="text" placeholder="Keyword" class="fl" id="keyword"/>
                        <select class="fl none" id="BusinessSubcategoryId">
                            <option value="">Choose a Sub-category</option>
                        </select>
                        <input type="submit" value="" class="fl" id="classsearchicon"/>
                    </div>
                </div>
            </div>
            <div class="list_det_cnt searchresultsummary" style="">
                <?php /* <div class="open-map"><a href="javascript:void(0);" title="Expand Map">&darr;</a></div>
                  <div class="close-map"><a href="javascript:void(0);" title="Minimize Map">&uarr;</a></div> */ ?>
                <div class="switch_list_icn relative" style="margin-bottom: 0px;">
                    <span class="fl" style="font-size:18px; color: #333;" id="search_result_count_message"></span>
                    <span class="text-f-map">Click to expand map</span>
                    <span class="map-x"><a class="anchor togglemap  blink-map" id="togglemap"><i class="fa fa-expand togglemapicon" title="Expand Map"></i></a></span>
                    <a class="grid_view active viewblockstoggle anchor" data-view="grid"></a>
                    <a class="list_view viewblockstoggle anchor" data-view="list"></a>
                </div>
            </div>
            <div class="cb"></div>
            <div class="relative" style="background: #fff; min-height: 200px;">
                <div id="content_box"></div>
                <div id="content_loader" class="pageloader none"><center>Loading...</center></div>
            </div>
        </div>
        <div class="cb"></div>
    </div>
</div>
<input type="hidden" id="localityLatitude"/>
<input type="hidden" id="localityLongitude"/>
<script>
        var BUSINESS_SEARCH_PAGE_LIMIT = <?php echo BUSINESS_SEARCH_PAGE_LIMIT; ?>;
        var map = null;
        var clusterrest = false;
        var markerClusterer = null;
        var infowindow;
        var markerBounds = null;
        var markers = [];
        var cluster = [];
        var min = .999999;
        var max = 1.000001;
        var addr = "";
        var customIcons = {
            restaurant: {
                icon: 'map_icons/adventure.png',
                shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
            },
            def: {
                icon: '<?php echo HTTP_ROOT;?>images/spotlight-poi1.png',
                shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
            }
        };
        $(document).ready(function(){
            if($(window).width() < 670){
              $('.filter-icon-mobile').click(function(){
                  if($(this).is(':visible')){
                      $(this).hide();
                      $('.top_m_ttl').show();
                      $(".mobile-view-filter").slideDown('1500','linear');
                      $('#biz_facilities').jScrollPane();
                  }
              });
                $('.top_m_ttl').click(function(){
                    if($(this).is(':visible')){
                      $(".mobile-view-filter").slideUp('1500','linear',function(){
                        $('.top_m_ttl').hide();
                        $('.filter-icon-mobile').show();
                      });
                  }
                });
            }
        });
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                scrollwheel:false,
                center: {lat: 20.2960587, lng: 85.82453980000003}
            });
            infowindow = new google.maps.InfoWindow();

            $('#map').css('background-image','none');
            google.maps.event.addListener(map,'zoom_changed',function (event) {
                var czoom = map.getZoom();
                if(czoom>16 && clusterrest === false){
                    clusterrest = true;
                    Search.resetClusters('hide');
                    //Search.set_markers(Search.marks,'no');
                }else if(czoom<17 && clusterrest === true){
                    clusterrest = false;
                    Search.resetClusters('show');
                    //Search.set_markers(Search.marks,'reset');
                }
            });


                <?php if($this->Session->read('user_location.lon') == ''){ ?>
                    // Try HTML5 geolocation.
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var pos = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            };
                            var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                            var geocoder = new google.maps.Geocoder();
                            geocoder.geocode({'location': latlng}, function(results, status) {
                                if (status == google.maps.GeocoderStatus.OK) {
                                    if (results[1]) {
                                        //jQuery("#where_search_2102").val(results[0].formatted_address);
                                        $("#localityLatitude, #latitude").val(results[1].geometry.location.lat());
                                        $("#localityLongitude, #longitude").val(results[1].geometry.location.lng());
                                        save_data();
                                    }
                                }
                            });
                        }, function() {
                            handleLocationError(true, infowindow, map.getCenter());
                        });
                    } else {
                        // Browser doesn't support Geolocation
                        handleLocationError(false, infowindow, map.getCenter());
                    }
                <?php } ?>
        }
        function geocodeAddress(geocoder, resultsMap, address) {
            //var address = document.getElementById('address').value;
            geocoder.geocode({'address': address}, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    setMapOnAll(null);
                    resultsMap.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: resultsMap,
                        draggable: true,
                        position: results[0].geometry.location
                    });
                    google.maps.event.addListener(marker, 'dragend', function() {
                        geocodePosition(marker.getPosition());
                    });
                    markers.push(marker);
                    console.log(results[0].formatted_address);
                    Business.set_address(results[0].formatted_address);
                    //console.log(results[0].geometry.location)
                    $('#latitude').val(results[0].geometry.location.G);
                    $('#longitude').val(results[0].geometry.location.K);
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
            geocoder.geocode({latLng: pos},
            function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    $('#latitude').val(results[0].geometry.location.G);
                    $('#longitude').val(results[0].geometry.location.K);
                    console.log(results[0].formatted_address);
                    Business.set_address(results[0].formatted_address);
                    //$("#mapSearchInput").val(results[0].formatted_address);
                    //$("#mapErrorMsg").hide(100);
                } else {
                    console.log('Cannot determine address at this location.' + status);
                    //$("#mapErrorMsg").html('Cannot determine address at this location.'+status).show(100);
                }
            }
            );
        }


        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            //infoWindow.setPosition(pos);
            //infoWindow.setContent(browserHasGeolocation ?'Error: The Geolocation service failed.' :'Error: Your browser doesn\'t support geolocation.');
        }

        function save_data(){
                var params = {lat:$("#localityLatitude").val(),lon:$("#localityLongitude").val(),'city':$('#localityCity').val(),'cityid':$('#localityCityId').val()};
                $.post(HTTP_ROOT+'content/update_location',params,function(response){console.log(response)});
        }
</script>
