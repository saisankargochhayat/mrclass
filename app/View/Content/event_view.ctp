<?php
if (trim($event['Event']['latitude']) != '' && trim($event['Event']['longitude']) != "") {
    echo $this->Html->script('https://maps.googleapis.com/maps/api/js?key=' . GOOGLE_MAP_KEY . '&libraries=places&callback=initMap', array('inline' => false));
}
?>
<?php
$login_url = $this->Html->url(array('controller' => 'users', 'action' => 'login')) . "?from=" . $this->params->url;
$EventId = $event['Event']['id'];
$status = $event['Event']['status'];
?>
<style type="text/css">
    .bs-actions{margin-right:5%; margin-left: 0; margin-bottom: 15px;}
    .add1-con h4{margin: 0px;}
    .rating_star{margin-right:5%;}
    .img-bs-content{width:100%;}
    .silver_bg .link-social{min-height: 40px;}
    .business_type_lbl{font-size: 12px;}
    .static_pg_cnt h4{margin-bottom:0px;}
    .static_pg_cnt h4 i{margin-top:10px;}
    .static_pg_cnt h4.panel-title{background-size:5%;}
    .static_pg_cnt .panel-heading{padding:0 10px;}
    .static_pg_cnt h4.panel-title{padding:0 0 0 38px}
    .accordion-toggle{top: -4px;}
    #amazingslider-2{height: auto !important;}
    .amazingslider-nav-0{position:initial !important;}
</style>
<div class="wrapper cat_det_page">
    <div class="breadcrumbs">
        <ul class="fl" style="max-width:90%;">
            <li><a href="http://www.mrclass.in/">Home</a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'event_list')) ?>">Events</a></li>
            <li class="ellipsis-view" style="max-width:60%;"><?php echo h($event['Event']['name']); ?></li>
        </ul>
        <?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
            <div class="back_btn fr none">
                <a class="anchor" onclick="window.history.back();"> <span style="font-size:20px;font-weight:bold">&larr;</span> Go Back</a>
            </div>
        <?php } ?>
        <div class="cb"></div>
    </div>
    <div class="cb"></div>
    <div class="silver_bg">
        <div class="wid-r-45 fl">
            <?php if (trim($event['Event']['latitude']) != '' && trim($event['Event']['longitude']) != "") { ?>
                <div class="cb"></div>
                <div class="sub-head-dsc">Location</div>
                <div class="cb10"></div>
                <div id="map" style="height:278px;"></div>
            <?php } ?>&nbsp;
            <div class="add1-con">
                <h4><?php echo h($event[0]['fulladdress']); ?></h4>
                <div class="business_phones mtop10">
                    <div class="sub-head-dsc mright10 fl">Phone Number</div>
                    <h5 class="fl">
                        <?php $pvalue = $event['Event']['phone']; ?>
                        <a href="tel:<?php echo $this->Format->maskMobile($this->Format->formatPhoneNumber($pvalue), 'x'); ?>" class="masked_numbers none">
                            <?php echo $this->Format->maskMobile($this->Format->formatPhoneNumber($pvalue), 'x'); ?>
                        </a>
                        <a href="tel:<?php echo $this->Format->formatPhoneNumber($pvalue); ?>" class="masked_numbers">
                            <?php echo $this->Format->formatPhoneNumber($pvalue); ?>
                        </a>
                    </h5>
                    <div class="cb"></div>
                </div>
                <div class="business_contact_person" id="masked_email">
                    <div class="sub-head-dsc mright10 fl">EMAIL ID</div>
                    <h6 class="fl none"><a href="javascript:void(0);" title="<?php echo $this->Format->mask_email($event['Event']['email'], 'x', 100); ?>"><?php echo $this->Text->truncate($this->Format->mask_email($event['Event']['email'], 'x', 100), 25, array('ellipsis' => '...', 'exact' => true, 'html' => false)); ?></a></h6>
                    <h6 class="fl"><a href="mailto:<?php echo h($event['Event']['email']); ?>"><?php echo $event['Event']['email']; ?></a></h6>
                    <div class="cb"></div>
                </div>
                <div class="business_contact_person none" id="masked_number_link">
                    <i class="fa fa-exclamation-circle" style="color:#aaa;"></i> <a class="phone_mask" title="Click to view contact information" href="javascript:void(0)">Click to View</a> &nbsp;&nbsp;<i class="fa fa-refresh fa-spin spinner" style="display:none;color:#aaa;"></i>
                </div>

                <?php /* <div class="sub-head-dscmright10 fl">Website</div>
                  <h3 class="fl"><a href="http://www.iiht.com/contact.php" target="_blank">http://www.iiht.com/contact.php</a></h3> */ ?>

                <div class="cb"></div>
            </div>
            <div class="add1-con">
                <div class="sub-head-dsc mright10 fl">Contact Person</div>
                <div class="business_contact_person">
                    <i class="fa fa-user contact_icon"></i> 
                    <span class="person_name_text"><a href="javascript:void(0);" title="<?php echo $event['Event']['contact_person']; ?>"><?php echo $this->Text->truncate($event['Event']['contact_person'], 25, array('ellipsis' => '...', 'exact' => true, 'html' => false)); ?></a></span>
                </div>
                <div class="cb"></div>
                <div class="cb20"></div>
            </div>
            <div class="cb"></div>
        </div>
        <div class="wid-r-50 fl">
            <div class="content-parent">
                <div class="wid-r-75 fl">
                    <div class="top-text"><?php echo h($event['Event']['name']); ?></div>
                    <div class="cb"></div>

                </div>
                <div class="wid-r-25 fr rt_dt_cnt_ph relative">
                    <div class="fr border1c" style="">
                        <img src="<?php echo $this->Format->show_event_banner($event, 100, 100, 0) ?>" alt="" style="height:100%; width:100%; max-height: 100px;">
                    </div>
                </div>
                <div class="cb"></div>
            </div>

            <div class="content-parent">
                <div class="wid-r-70 fl"></div>
                <div class="wid-r-30 fr rt_dt_cnt_ph"></div>
                <div class="cb"></div>
            </div>
            <div class="cb20"></div>

            <div class="business_more_details">
                <p class="more-description-text">
                    <span class="sub-head-dsc">Entry Fee:</span>
                    <?php echo $event['Event']['fee_type'] == 'free' ? "Free" : $this->Format->price(h($event['Event']['fee'])); ?>
                </p>

                <p class="more-description-text">
                    <span class="sub-head-dsc">Equipment Provided:</span>
                    <?php echo $event['Event']['is_equipment_provided'] === '1' ? "Yes" : "No"; ?>
                </p>
                <p class="more-description-text">
                    <span class="sub-head-dsc">Event on:</span>
                    <?php echo $this->Format->dateFormat(h($event['Event']['start_date'])); ?>
                    <?php echo $event['Event']['schedule_type'] == 'Specific' ? " to " . $this->Format->dateFormat(h($event['Event']['end_date'])) : ""; ?>
                </p>
            </div>
            <div class="cb20"></div>
            <?php
            if (date("Y-m-d", strtotime($event['Event']['start_date'])) < date("Y-m-d")) {
                $inactiveLink = "inactiveLink";
            } else {
                $inactiveLink = "";
            }
            ?>
            <?php if ($inactiveLink != '' || $status === '0') { ?>
                <?php /* <div class="fl btn-new-req">Event has been over. </div> */ ?>
            <?php } else { ?>
                <div class="fl btn-new-req">
                    <a data-href="<?php echo $this->Html->url('/content/event_inquiry/' . $EventId . "/not-going") ?>" onclick="event.preventDefault();" class="anchor ajax cboxElement">Not Going</a>
                </div>
                <div class="fl btn-new-req">
                    <a data-href="<?php echo $this->Html->url('/content/event_inquiry/' . $EventId . "/may-go") ?>" onclick="event.preventDefault();" class="anchor ajax cboxElement">May Go</a>
                </div>
                <div class="fl btn-new-req">
                    <a data-href="<?php echo $this->Html->url('/content/event_inquiry/' . $EventId . "/going") ?>" onclick="event.preventDefault();" class="anchor ajax cboxElement">Surely Going</a>
                </div>
            <?php } ?>
            <div class="cb20"></div>

            <div class="sub-head-dsc">Description</div>
            <p class="description-text"><?php echo nl2br(h($event['Event']['description'])); ?></p>
        </div>
        <div class="cb"></div>
    </div>
</div>
<div class="cb">&nbsp;</div>
<script type="text/javascript">
    var stats = "<?php echo $status; ?>";
    var b_id = "<?php echo $EventId; ?>" || "";
    var b_path;
    var mask_link = false;
    var fav_link = false;
    $(document).ready(function () {
        if (window.history.length > 2) {
            $('.back_btn').show();
        }
        $('.phone_mask').click(function () {
            var _this = $(this);
            if (SESSION_USER) {
                if (mask_link === true)
                    return false;
                mask_link = true;

                $('.spinner').show();
                $.ajax({
                    url: HTTP_ROOT + 'inquiries/save_requester_data',
                    type: 'POST',
                    dataType: "json",
                    data: {user_data: {'user_id': SESSION_USER, 'business_id': b_id}},
                    success: function (response) {
                        if (typeof response == "object") {
                            $('.masked_numbers').each(function (index, el) {
                                $(this).text(response[index]);
                            });
                            $('#masked_email a').attr('href', 'mailto:' + response['masked_email']).text(response['masked_email']);
                            $('#masked_number_link').hide();
                        } else {
                            mask_link = false;
                            $('.spinner').hide();
                            alert("Something went wrong. Try again later.", "error");
                        }
                    }
                });
            } else {
                alert("<a href='/login?from=b-432-indian-institute-of-hardware-technology' style='color:black;'>Sign In</a> to view the contact information details.", "error");
            }
        });
        $('.user-favorite').click(function () {
            var _this = $(this);
            if (SESSION_USER) {
                if (fav_link === true)
                    return false;
                fav_link = true;
                var mark_mode = parseInt($(this).attr('data-marked'));
                var mark_status = (mark_mode) ? "unmark" : "mark";
                $('.overlay_div').show();
                $.ajax({
                    url: HTTP_ROOT + 'businesses/save_favorite_data',
                    type: 'POST',
                    dataType: "json",
                    data: {user_data: {'user_id': SESSION_USER, 'business_id': b_id, 'mark_status': mark_status}},
                    success: function (response) {
                        if (response.status) {
                            $('.overlay_div').hide();
                            (mark_status == "unmark") ? _this.removeClass('marked-fav').addClass('unmarked-fav') : _this.removeClass('unmarked-fav').addClass('marked-fav');
                            (mark_status == "unmark") ? _this.attr('data-marked', '0') : _this.attr('data-marked', '1');
                            (mark_status == "unmark") ? _this.attr('title', 'Add this business to your favorites') : _this.attr('title', 'Added to favorites');
                            alert(response.statusText, "success");
                        } else {
                            $('.overlay_div').hide();
                            alert(response.statusText, "error");
                        }
                        fav_link = false;
                    }
                });
            } else {
                alert("<a href='/login?from=b-432-indian-institute-of-hardware-technology' style='color:black;'>Sign In</a> to add this business as your favorites.", "error");
            }
        });
    });
<?php if (trim($event['Event']['latitude']) != '' && trim($event['Event']['longitude']) != "") { ?>
        var lat = parseFloat("<?php echo trim($event['Event']['latitude']); ?>");
        var lng = parseFloat("<?php echo trim($event['Event']['longitude']); ?>");

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {zoom: 15, scrollwheel: false, center: {lat: lat, lng: lng}});
            var geocoder = new google.maps.Geocoder();
            var marker = new google.maps.Marker({map: map, position: {lat: lat, lng: lng}});
            var infowindow = new google.maps.InfoWindow();
            google.maps.event.addListener(marker, 'mouseover', (function (marker) {
                var content = '<div class="newinfo"><img src="http://www.mrclass.in/thumbs/8a02e4921ef16353ce5eab6facb12ec0.png" alt="" height="100" width="100"/>';
                content += '<div class="icont"><b style="font-size:16px;">Indian Institute of Hardware Technology </b>';
                content += '<p class="addr">Plot No. - 1/14, Ground Floor,IRC Village, Opposite CRPF main gate <br/>Nayapalli, Bhubaneswar - 751015</p>';
                content += '';
                content += '</div></div>';
                return function () {
                    if (!$('.togglemapicon').hasClass('fa-expand')) {
                        infowindow.setContent(content);
                        infowindow.open(map, marker);
                    }
                }
            })(marker));
            google.maps.event.addListener(infowindow, 'domready', function () {

                var iwOuter = $('.gm-style-iw');
                //iwOuter.parent('div').css('background','#fff');
                var iwBackground = iwOuter.prev();
                iwBackground.children(':nth-child(2)').css({'display': 'none'});
                iwBackground.children(':nth-child(4)').css({'display': 'none'});
                //iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index' : '1','background':'rgb(238, 121, 69)'});
                iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'background': 'rgb(238, 121, 69)'});
                var iwCloseBtn = iwOuter.next();
                iwCloseBtn.css({opacity: '1', right: '33px', top: '3px', 'box-shadow': '0 0 5px #3990B9'});
                if ($('.iw-content').height() < 140) {
                    $('.iw-bottom-gradient').css({display: 'none'});
                }
                iwCloseBtn.mouseout(function () {
                    $(this).css({opacity: '1'});
                });
            });
        }
<?php } ?>
    function toggleChevron(e) {
        $(e.target).closest('.panel').find('.indicator').toggleClass('ion-minus ion-plus');
    }
    $('#accordion').on('hidden.bs.collapse', toggleChevron);
    $('#accordion').on('shown.bs.collapse', toggleChevron);
</script>