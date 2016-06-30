<?php
echo $this->Html->css(array('rateit'));
echo $this->Html->script(array('rateit/jquery.rateit.min'), array('inline' => false));
#echo $this->Html->script(array('jssor', 'jssor.slider'), array('inline' => false));
#echo $this->Html->script(array('videogallery/html5gallery/html5gallery'), array('inline' => false));
echo $this->Html->script(array('business_detail'), array('inline' => false));
echo $this->Html->script(array('accordian'), array('inline' => false));
echo $this->Html->script(array('amazingslider', 'initslider'), array('inline' => false));
if (trim($business['Business']['latitude']) != '' && trim($business['Business']['longitude']) != "") {
    echo $this->Html->script('https://maps.googleapis.com/maps/api/js?key=' . GOOGLE_MAP_KEY . '&libraries=places&callback=initMap', array('inline' => false));
}
?>
<?php $login_url = $this->Html->url(array('controller' => 'users', 'action' => 'login')) . "?from=" . $this->params->url; ?>
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
<?php
$BusinessId = $business['Business']['id'];
$status = intval($business['Business']['status']);
?>
<?php
$image_limit = (isset($subscription['Subscription']['photo_limit'])) ? intval($subscription['Subscription']['photo_limit']) : "";
$video_limit = (isset($subscription['Subscription']['video_limit'])) ? intval($subscription['Subscription']['video_limit']) : "";
$faq_limit = (isset($subscription['Subscription']['faq'])) ? intval($subscription['Subscription']['faq']) : "";
?>
<div class="wrapper cat_det_page">
    <div class="breadcrumbs">
        <ul class="fl" style="max-width:90%;">
            <li><a href="<?php echo HTTP_ROOT; ?>">Home</a></li>
            <?php /* ?><li><a href="<?php echo HTTP_ROOT.'search/#cid='.h($business['Category']['id']) ?>"><?php echo h($business['Category']['name']);?></a></li>
              <li><a href="<?php echo HTTP_ROOT.'search/#sid='.h($business['SubCategory'][0]['id']) ?>"><?php echo h($business['SubCategory'][0]['name']);?></a></li><?php */ ?>
            <li><a href="<?php echo HTTP_ROOT . 'search/#lc=' . h($business['Locality']['id']) ?>"><?php echo h($business['Locality']['name']); ?></a></li>
            <li class="ellipsis-view" style="max-width:60%;"><?php echo h($business['Business']['name']); ?></li>
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
            <?php if (trim($business['Business']['latitude']) != '' && trim($business['Business']['longitude']) != "") { ?>
                <?php if ($this->Format->is_allowed($subscription, $user['type'], 'Map')) { ?>
                    <div class="cb"></div>
                    <div class="sub-head-dsc">Location</div>
                    <div class="cb10"></div>
                    <div id="map" style="height:278px;"></div>
                <?php } ?>
            <?php } ?>&nbsp;    
            <div class="add1-con">
                <h4>
                    <?php echo h(trim($business['Business']['address'])); ?>,
                    <?php echo (trim($business['Business']['landmark'])) != '' ? h(trim($business['Business']['landmark'])) . "" : ""; ?>
                    <?php echo h(trim($business['Locality']['name'])); ?>
                    <?php echo h(trim($business['City']['name'])); ?>
                </h4>          
                <div class="business_phones mtop10">
                    <div class="sub-head-dsc mright10 fl">Phone Number</div>
                    <?php $phones = $this->Format->multi_phone($business['Business']['phone']); ?>
                    <?php if (is_array($phones)) { ?>
                    <?php $phones_cnt = 0 ?>
                        <h5 class="fl">
                            <?php foreach ($phones as $pkey => $pvalue) { ?>
                                <?php if (empty($user)) { ?>
                                    <a href="tel:<?php echo $this->Format->maskMobile($this->Format->formatPhoneNumber($pvalue), 'x'); ?>" class="masked_numbers">
                                        <?php echo $this->Format->maskMobile($this->Format->formatPhoneNumber($pvalue), 'x'); ?>
                                    </a>
                                <?php } else { ?>
                                    <?php if ($user['type'] == '1' || $user['id'] == $business['Business']['user_id']) { ?>
                                        <a href="tel:<?php echo $this->Format->formatPhoneNumber($pvalue); ?>" class="masked_numbers">
                                            <?php echo $this->Format->formatPhoneNumber($pvalue); ?>
                                        </a>
                                    <?php } else { ?>
                                        <?php /* <?php if(empty($contact_number_erquested)){?>
                                          <a href="tel:<?php echo $this->Format->maskMobile($this->Format->formatPhoneNumber($pvalue),'x'); ?>" class="masked_numbers">
                                          <?php echo $this->Format->maskMobile($this->Format->formatPhoneNumber($pvalue),'x'); ?>
                                          </a>
                                          <?php } else {?>
                                          <a href="tel:<?php echo $this->Format->formatPhoneNumber($pvalue); ?>" class="masked_numbers">
                                          <?php echo $this->Format->formatPhoneNumber($pvalue); ?>
                                          </a>
                                          <?php }?> */ ?>
                                        <a href="tel:<?php echo $this->Format->maskMobile($this->Format->formatPhoneNumber($pvalue), 'x'); ?>" class="masked_numbers">
                                            <?php echo $this->Format->maskMobile($this->Format->formatPhoneNumber($pvalue), 'x'); ?>
                                        </a>
                                    <?php } ?>
                                <?php } ?>
                                <?php $phones_cnt++ ?>
                                <?php if(count($phones)>$phones_cnt) echo ",&nbsp;";?>
                                <?php if($phones_cnt%2 == 0) echo "<br/>";?>
                                
                            <?php } ?>
                        </h5>
                    <?php } else { ?>
                        <h5 class="fl">
                            <?php if (empty($user)) { ?>
                                <a href="tel:<?php echo $this->Format->maskMobile($this->Format->formatPhoneNumber($phones), 'x'); ?>" class="masked_numbers">
                                    <?php echo $this->Format->maskMobile($this->Format->formatPhoneNumber($phones), 'x'); ?>
                                </a>
                            <?php } else { ?>
                                <?php if ($user['type'] == '1' || $user['id'] == $business['Business']['user_id']) { ?>
                                    <a href="tel:<?php echo $this->Format->formatPhoneNumber($phones); ?>" class="masked_numbers">
                                        <?php echo $this->Format->formatPhoneNumber($phones); ?>
                                    </a>
                                <?php } else { ?>
                                    <?php /* <?php if(empty($contact_number_erquested)){?>
                                      <a href="tel:<?php echo $this->Format->maskMobile($this->Format->formatPhoneNumber($phones),'x'); ?>" class="masked_numbers">
                                      <?php echo $this->Format->maskMobile($this->Format->formatPhoneNumber($phones),'x'); ?>
                                      </a>
                                      <?php } else {?>
                                      <a href="tel:<?php echo $this->Format->formatPhoneNumber($phones); ?>" class="masked_numbers">
                                      <?php echo $this->Format->formatPhoneNumber($phones); ?>
                                      </a>
                                      <?php }?> */ ?>
                                    <a href="tel:<?php echo $this->Format->maskMobile($this->Format->formatPhoneNumber($phones), 'x'); ?>" class="masked_numbers">
                                        <?php echo $this->Format->maskMobile($this->Format->formatPhoneNumber($phones), 'x'); ?>
                                    </a>
                                <?php } ?>
                            <?php } ?>
                        </h5>
                    <?php } ?>
                    <div class="cb"></div>
                </div>
                <div class="business_contact_person" id="masked_email">
                    <div class="sub-head-dsc mright10 fl">EMAIL ID</div>
                    <?php if (empty($user)) { ?>
                        <h6 class="fl"><a href="javascript:void(0);" title="<?php echo $this->Format->mask_email($business['Business']['email'], 'x', 100); ?>"><?php echo $this->Text->truncate($this->Format->mask_email($business['Business']['email'], 'x', 100), 25, array('ellipsis' => '...', 'exact' => true, 'html' => false)); ?></a></h6>
                    <?php } else { ?>
                        <?php if ($user['type'] == '1' || $user['id'] == $business['Business']['user_id']) { ?>
                            <h6 class="fl"><a href="mailto:<?php echo h($business['Business']['email']); ?>"><?php echo $business['Business']['email']; ?></a></h6>
                        <?php } else { ?>
                            <?php /* <?php if(empty($contact_number_erquested)){?>
                              <h6 style="margin-top: 25px;"><a href="javascript:void(0);"><?php echo $this->Format->mask_email($business['Business']['email'],'x',100); ?></a></h6>
                              <?php } else {?>
                              <h6 style="margin-top: 25px;"><a href="mailto:<?php echo h($business['Business']['email']); ?>"><?php echo $business['Business']['email']; ?></a></h6>
                              <?php }?> */ ?>
                            <h6 class="fl"><a href="javascript:void(0);" title="<?php echo $this->Format->mask_email($business['Business']['email'], 'x', 100); ?>"><?php echo $this->Text->truncate($this->Format->mask_email($business['Business']['email'], 'x', 100), 25, array('ellipsis' => '...', 'exact' => true, 'html' => false)); ?></a></h6>
                        <?php } ?>
                    <?php } ?>
                    <div class="cb"></div>
                </div>
                <?php if (!empty($user)) { ?>
                    <?php if ($user['type'] != '1' && $user['id'] != $business['Business']['user_id']) { ?>
                        <?php /* <?php if(empty($contact_number_erquested)){?> */ ?>
                        <div class="business_contact_person" id="masked_number_link">
                            <i class="fa fa-exclamation-circle" style="color:#aaa;"></i> <a class="phone_mask" title="Click to view contact information" href="javascript:void(0)" >Click to View</a> &nbsp;&nbsp;<i class="fa fa-refresh fa-spin spinner" style="display:none;color:#aaa;"></i>
                        </div>
                        <?php /* <?php } ?> */ ?>
                    <?php } ?>
                <?php } else { ?>
                    <div class="business_contact_person" id="masked_number_link">
                        <i class="fa fa-exclamation-circle" style="color:#aaa;"></i> <a class="phone_mask" title="Click to view contact information" href="javascript:void(0)" >Click to View</a> &nbsp;&nbsp;<i class="fa fa-refresh fa-spin spinner" style="display:none;color:#aaa;"></i>
                    </div>
                <?php } ?>
                
                <?php if (trim($business['Business']['website']) != '') { ?>
                    <div class="sub-head-dsc  mright10 fl">Website</div>
                    <h3 class="fl"><a href="<?php echo h($business['Business']['website']); ?>" target="_blank"><?php echo h($business['Business']['website']); ?></a></h3>
                    <div class="cb"></div>
                <?php } ?>
            </div>
            <div class="add1-con">
                <?php if (!empty($business['Business']['contact_person'])) { ?>
                    <div class="sub-head-dsc mright10 fl">Contact Person</div>
                    <div class="business_contact_person">
                        <i class="fa fa-user contact_icon"></i> 
                        <span class="person_name_text"><a href="javascript:void(0);" title="<?php echo $business['Business']['contact_person']; ?>"><?php echo $this->Text->truncate($business['Business']['contact_person'], 25, array('ellipsis' => '...', 'exact' => true, 'html' => false)); ?></a></span>
                    </div>
                <?php } ?>
                <div class="cb"></div>
                
                <div class="cb20"></div>
            </div>    
            <?php $gallery = $BusinessGallery; ?>
            <?php if (!empty($gallery) && count($gallery) > 0) { ?>
            <?php $video_allowed = $this->Format->is_allowed($subscription, $user['type'], 'Video'); ?>
            <?php $video_count = 0; ?>
            <?php $image_found = 'No'; ?>
            <div id="amazingslider-2" style="display:block;position:relative;">
                <ul class="amazingslider-slides" style="display:block;">
                    <?php foreach ($gallery as $key1 => $gal) { ?>

                        <?php $image_found = 'Yes'; ?>
                        <?php if (trim($gal['type']) == 'image') { ?>
                            <li>
                                <img src="<?php echo $this->Format->gallery_image($gal, $BusinessId, 510, 262, 0); ?>" alt="Tulip and Sky" />
                            </li>
                        <?php } else { ?>
                            <?php if ($video_allowed && isset($video_limit) && !empty($video_limit) && ($video_limit > $video_count) && ($user['type'] != '1')) { ?>
                                <li>
                                    <img src="<?php echo $this->Format->get_video_url($gal, "image"); ?>" alt="Big Buck Bunny" />
                                    <video preload="none" src="<?php echo $this->Format->get_video_url($gal); ?>"></video>
                                </li>
                                <?php $video_count++; ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </ul>
                <ul class="amazingslider-thumbnails" style="display:block;">
                    <?php foreach ($gallery as $key1 => $gal) { ?>
                        <?php if (trim($gal['type']) == 'image') { ?>
                            <li><img src="<?php echo $this->Format->gallery_image($gallery[$key1], $BusinessId, 99, 66, 1); ?>" /></li>
                        <?php } else { ?>
                            <?php if ($video_allowed && isset($video_limit) && !empty($video_limit) && ($video_limit > $video_count) && ($user['type'] != '1')) { ?>
                                <li><img src="<?php echo $this->Format->get_video_url($gal, "image"); ?>" /></li>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </ul>
                <div class="cb20"></div>
            </div>
                    <?php } ?>
            <div class="cb"></div>

            <?php if (!empty($business['BusinessFaq']) && count($business['BusinessFaq']) > 0) { ?>
                <?php if ($this->Format->is_allowed($subscription, $user['type'], 'Faq')) { ?>
                    <div class="cb20"></div>
                    <div class="sub-head-dsc">Business Faqs</div>
                    <div class="cb20"></div>
                    <div class="static_pg_cnt">
                        <?php $faq_count = 0; ?>
                        <div>
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <?php foreach ($business['BusinessFaq'] as $key => $val) { ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title anchor" data-toggle="collapse" data-parent="#accordion" 
                                                href="#collapse<?php echo h($key); ?>" aria-expanded="false" aria-controls="collapse<?php echo $key; ?>">
                                                <a class="accordion-toggle">
                                                    <?php echo h($val['title']) ?>
                                                </a><i class="indicator ion ion-plus  pull-right"></i>
                                            </h4>
                                        </div>
                                        <div id="collapse<?php echo h($key); ?>" class="panel-collapse collapse">
                                            <div class="panel-body"><?php echo trim($val['content']) ?></div>
                                        </div>
                                    </div>
                                    <?php $faq_count++; ?>
                                    <?php if (isset($faq_limit) && !empty($faq_limit) && ($faq_limit == $faq_count) && ($user['type'] != '1')) break; ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>  
            <?php } ?>
            <div class="sub-head-dsc <?php echo count($reviews) > 0 ? "" : "none"; ?>"><span class="review_count"><?php echo count($reviews); ?></span> review(s)</div>
            <div class="cb20"></div>
            <div id="review_box" class="review-box">
                <?php if (is_array($reviews) && count($reviews) > 0) { ?>
                    <?php foreach ($reviews as $review) { ?>
                        <?php echo $this->element('business_review', array('review' => $review)) ?>
                    <?php } ?>
                <?php } elseif ($this->Session->read('Auth.User.id') == $business['Business']['user_id']) { ?>
                <?php } else { ?>
                    <p class="no_review_block">Be the first to give review.</p>
                <?php } ?>
            </div>
            <div class="cb"></div>
            <?php if ($this->Session->read('Auth.User.id') != $business['Business']['user_id']) { ?>
                <div class="bg-post-white" id="review">
                    <?php if ($this->Session->read('Auth.User.id') > 0) { ?>
                        <?php //echo $this->Form->create('Review', array('autocomplete' => 'off'));    ?>
                        <div class="rating_star">
                            Give a Rating:
                            <div class="rateit12" id="rateit9" style="width: 100px;"></div>
                            <input type="hidden" id="backingfld" style="width: 100px;"/>
                            <span id="backingfld_span" style="color:#EA632C"></span>
                        </div>
                        <div class="cb"></div>
                        <div class="bg-user-ico">
                            <input type="text" class="form-control fl" placeholder="Write a Review..." id="txt_review" style="width:80%;"/>
                            <input type="button" class="submit-post fl" value="Post" id="submit_review" data-bid="<?php echo $BusinessId; ?>" style="width:20%;"/>
                            <div class="cb"></div>
                        </div>
                        <?php //echo $this->Form->end();    ?>
                    <?php } else { ?>
                        <p>Please <a href="<?php echo $login_url; ?>" style="text-decoration:none;"><b>Sign In</b></a> to give your review. </p>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <div class="wid-r-50 fl">
            <div class="content-parent">
                <div class="wid-r-75 fl">
                    <div class="top-text">
                        <?php echo h($business['Business']['name']); ?>
                        <span style="font-size:18px;">
                            <?php if ($business['Business']['type'] == 'private') { ?>
                                <?php /* ?><i class="ion ion-ios-locked business_type_icon" title="Private"></i><?php */ ?>
                                <span class="business_type_lbl" title="Private">(Private)</span>
                            <?php } else { ?>
                                <i class="fa fa-users business_type_icon" style="visibility:hidden;" title="Group"></i>
                            <?php } ?>
                        </span>
                        <?php if ($status != 1) { ?>
                            <div class="status_mybus" style="position:relative; top:0px; display: inline-block; font-size: 18px; ">
                                <span class="fa fa-warning" title="Approval Pending"></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="cb"></div>
                    <div style="width:100%;padding-top: 20px;">
                        <?php $rating = isset($business['BusinessRating'][0]['BusinessRating'][0]['rating']) ? $business['BusinessRating'][0]['BusinessRating'][0]['rating'] : 0; ?>
                        <?php $reviews_count = isset($business['BusinessRating'][0]['BusinessRating'][0]['reviews_count']) ? $business['BusinessRating'][0]['BusinessRating'][0]['reviews_count'] : 0; ?>
                        <?php #if ($reviews_count > 0) {  ?>
                        <div class="fl rating_star">
                            <?php echo $this->element('view_rating', array('rating' => $rating, 'reviews_count' => $reviews_count)) ?>
                        </div>
                        <?php #}     ?>

                        <!--<div class="fl bs-actions exp-ico">Experience </div>-->
                        <?php if ($this->Session->read('Auth.User.id') != $business['Business']['user_id']) { ?>
                            <div class="fl bs-actions review-ico"><a href="#review" onclick="$('#txt_review').focus()">Write a Review</a> </div>
                        <?php } ?>

                        <div class="fl">
                            <div class="link-social">
                                <?php if ($this->Format->is_allowed($subscription, $user['type'], 'Social Media')) { ?>
                                    <?php if (trim($business['Business']['facebook']) != '') { ?>
                                        <a class="fb" href="<?php echo $this->Format->validate_url(h($business['Business']['facebook'])); ?>" target="_blank"></a>
                                    <?php } ?>
                                    <?php if (trim($business['Business']['twitter']) != '') { ?>
                                        <a class="tweet" href="<?php echo $this->Format->validate_url(h($business['Business']['twitter'])); ?>" target="_blank"></a>
                                    <?php } ?>
                                    <?php /* ?><a class="lin" href="<?php echo h($business['Business']['about_us']);?>"></a><?php */ ?>
                                    <?php if (trim($business['Business']['gplus']) != '') { ?>
                                        <a class="gplus" href="<?php echo $this->Format->validate_url(h($business['Business']['gplus'])); ?>" target="_blank"></a>
                                    <?php } ?>
                                    <?php if (trim($business['Business']['youtube']) != '') { ?>
                                        <a class="ytube" href="<?php echo $this->Format->validate_url(h($business['Business']['youtube'])); ?>" target="_blank"></a>
                                    <?php } ?>
                                <?php } ?>
                                <?php
                                if (!empty($user)) {
                                    $business_marked = ($is_marked_favorite) ? true : false;
                                    $business_marked_class = ($is_marked_favorite) ? "marked-fav" : "unmarked-fav";
                                    $business_marked_title = ($is_marked_favorite) ? "Added to favorites" : "Add this business to your favorites";
                                    ?>
                                    <a class="<?php echo $business_marked_class; ?> user-favorite favorite-heart" title="<?php echo $business_marked_title; ?>" data-marked="<?php echo $business_marked; ?>" href="javascript:void(0);"><i class="ion ion-heart"></i> </a>
                                <?php } else { ?>
                                    <a class="unmarked-fav user-favorite favorite-heart" title="Add this business to your favorites" href="javascript:void(0);"><i class="ion ion-heart"></i> </a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="cb"></div>
                    </div>
                </div>
                <div class="wid-r-25 fr rt_dt_cnt_ph relative">
                    <?php if($business['Business']['discount_allowed'] == 'yes'){?>
                        <div class="discount_tag blink-discount">
                            <img src="img/discount-logo1.png" alt="" class=""/>
                            <span class="discount_text"><?php echo $business['Business']['discount_type']=="flat"?"Rs.":""; ?><?php echo $business['Business']['discount_amount']; ?><?php echo $business['Business']['discount_type']=="flat"?"":"%"; ?> off</span>
                        </div>
                    <?php } ?>
                    <div class="fr border1c" style="">
                        <?php $logo = $this->Format->show_business_logo($business, 100, 100, 0); ?>
                        <img src="<?php echo $logo; ?>" alt="" style="height:100%; width:100%; max-height: 100px;"/>
                    </div>
                </div>
                <div class="cb"></div>
            </div>

            <div class="content-parent">
                <div class="wid-r-70 fl">
                </div>
                <div class="wid-r-30 fr rt_dt_cnt_ph">
                    <div class="cb"></div>
                </div>
                <div class="cb"></div>
            </div>
            <div class="bs-icons">
                <?php if (is_array($business['Facility']) && count($business['Facility']) > 0) { ?>
                    <?php foreach ($business['Facility'] as $facility) { ?>
                        <a title="<?php echo h($facility['name']); ?>" class="anchor <?php echo strtolower(h($facility['name'])); ?>">
                            <?php echo $this->Format->format_facility_icon($facility['image'], 'icon-user-grid', $facility); ?>
                        </a>
                    <?php } ?>
                <?php } ?>
            </div>



            <div class="cb20"></div>


            <div class="business_more_details">
                <?php if (trim($business['Business']['ratio']) != '') { ?>
                    <p class="more-description-text">
                        <span class="sub-head-dsc">Student:Teacher ratio:</span><?php echo $business['Business']['ratio']; ?>
                    </p>
                <?php } ?>
                <?php if (trim($business['Business']['gender']) != '') { ?>
                    <p class="more-description-text">
                        <span class="sub-head-dsc">Targeted Gender:</span>
                        <?php echo (ucfirst(h($business['Business']['gender'])) == "Both") ? "Both (Male & Female)" : ucfirst(h($business['Business']['gender'])); ?>
                    </p>
                <?php } ?>
                <?php if (floatval($business['Business']['price']) > 0) { ?>
                    <p class="more-description-text">
                        <span class="sub-head-dsc">Price:</span>
                        <?php echo $this->Format->price(h($business['Business']['price'])); ?>
                        <?php echo floatval($business['Business']['max_price']) > 0 ? " to " . $this->Format->price(h($business['Business']['max_price'])) : ""; ?>
                    </p>
                <?php } ?>
                <?php if (intval($business['Business']['min_age_group']) > 0 || intval($business['Business']['max_age_group']) > 0) { ?>
                    <p class="more-description-text">
                        <span class="sub-head-dsc">Age Group:</span>
                        <?php echo (h($business['Business']['min_age_group'])); ?>&nbsp;-&nbsp;<?php echo (h($business['Business']['max_age_group'])); ?> yrs
                    </p>
                <?php } ?>
                <?php if (trim($business['Business']['type']) == 'private') { ?>
                    <?php if (strtotime($business['Business']['dob']) > 0) { ?>
                        <p class="more-description-text">
                            <span class="sub-head-dsc">Age:</span>
                            <?php echo $this->Format->age(h($business['Business']['dob'])); ?>
                        </p>
                    <?php } ?>
                    <?php if (trim($business['Business']['preferred_location']) != '') { ?>
                        <p class="more-description-text">
                            <span class="sub-head-dsc">Preferred Location:</span>
                            <?php echo ucfirst(h($business['Business']['preferred_location'])); ?>'s place
                        </p>
                    <?php } ?>
                    <?php if (trim($business['Business']['free_demo_class']) != '') { ?>
                        <p class="more-description-text">
                            <span class="sub-head-dsc">Free Demo Class:</span>
                            <?php echo ucfirst(h($business['Business']['free_demo_class'])); ?>
                        </p>
                    <?php } ?>
                    <?php if (!empty($business['Business']['languages'])) { ?>
                        <p class="more-description-text">
                            <span class="sub-head-dsc">Languages Spoken:</span>
                            <?php
                            $i = 0;
                            $language_arr = array();
                            foreach ($business['Business']['languages'] as $key => $lang_id) {
                                if (isset($languages[$lang_id])) {
                                    $language_arr[] = $languages[$lang_id];
                                }
                            }
                            echo implode(', ', $language_arr);
                            ?>
                        </p>
                    <?php } ?>
                    <?php if (strtotime($business['Business']['established']) > 0) { ?>
                        <p class="more-description-text">
                            <span class="sub-head-dsc">Date of Establishment:</span>
                            <?php echo $this->Format->dateFormat(h($business['Business']['established'])); ?>
                        </p>
                    <?php } ?>
                    <?php if (trim(strip_tags($business['Business']['education'])) != '') { ?>
                        <p class="more-description-text">
                            <span class="sub-head-dsc">Education/Qualification:</span>
                            <?php echo nl2br(h($business['Business']['education'])); ?>
                        </p>
                    <?php } ?>
                    <?php if (trim(strip_tags($business['Business']['experience'])) != '') { ?>
                        <p class="more-description-text">
                            <span class="sub-head-dsc">Experience:</span>
                            <?php echo nl2br(h($business['Business']['experience'])); ?>
                        </p>
                    <?php } ?>
                <?php } ?>
            </div>
            <!--<a class="toggle-more-details anchor">More Details...</a>-->

            <div class="cb20"></div>

            <div class="fl btn-new-req <?php
            if ($this->Format->is_allowed($subscription, $user['type'], 'Call Request')) {
                echo "";
            } else {
                echo "inactiveLink";
            }
            ?>">
                <a data-href="<?php
                if ($this->Format->is_allowed($subscription, $user['type'], 'Call Request')) {
                    echo $this->Html->url('/businesses/request_call/' . $BusinessId);
                } else {
                    echo "";
                }
                ?>" onclick="event.preventDefault();" class="anchor <?php
                   if ($this->Format->is_allowed($subscription, $user['type'], 'Call Request')) {
                       echo 'ajax';
                   } else {
                       echo '';
                   }
                   ?>" title="<?php
                   if ($this->Format->is_allowed($subscription, $user['type'], 'Call Request')) {
                       echo "";
                   } else {
                       echo "The Business owner doesn't have this feature. Please call us on 0674 - 694 1111";
                   }
                   ?>">REQUEST A CALL</a>
            </div>
            <div class="fl btn-new-req"><a data-href="<?php echo $this->Html->url('/businesses/book_now/' . $BusinessId) ?>" onclick="event.preventDefault();" class="anchor ajax">BOOK NOW</a></div>
            <div class="cb20"></div>
            <?php if (is_array($courses) && !empty($courses)) { ?>
                <div class="cours_offer">
                    <div class="sub-head-dsc">Courses Offered:</div>
                    <ul>
                        <?php foreach ($courses as $course) { ?>
                            <li>
                                <?php echo $course['BusinessCourse']['name']; ?> 
                                <?php if (floatval($course['BusinessCourse']['price']) > 0) { ?> 
                                    (<?php echo $this->Format->price($course['BusinessCourse']['price']); ?>)
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="cb20"></div>
                </div>
            <?php } ?>

            <?php if (trim(strip_tags($business['Business']['about_us'])) != '') { ?>
                <div class="sub-head-dsc">Description</div>
                <p class="description-text"><?php echo nl2br(h($business['Business']['about_us'])); ?></p>
            <?php } ?>
        </div>
        <div class="cb"></div>
    </div>
</div>
<div class="cb">&nbsp;</div>
<script type="text/javascript">
    var stats = "<?php echo $status; ?>";
    var b_id = "<?php echo $business['Business']['id']; ?>" || "";
    var b_path;
    var mask_link = false;
    var fav_link = false;
    $(document).ready(function() {
        if (window.history.length > 2) {
            $('.back_btn').show();
        }
        $('.phone_mask').click(function() {
            var _this = $(this);
            if (SESSION_USER) {
                if (mask_link === true)
                    return false;
                mask_link = true;

                $('.spinner').show();
                //SESSION_USER['business_id'] = b_id;
                $.ajax({
                    url: HTTP_ROOT + 'inquiries/save_requester_data',
                    type: 'POST',
                    dataType: "json",
                    data: {user_data: {'user_id': SESSION_USER, 'business_id': b_id}},
                    success: function(response) {
                        if (typeof response == "object") {
                            $('.masked_numbers').each(function(index, el) {
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
                alert("<a href='<?php echo $login_url; ?>' style='color:black;'>Sign In</a> to view the contact information details.", "error");
            }
        });
        $('.user-favorite').click(function() {
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
                    success: function(response) {
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
                alert("<a href='<?php echo $login_url; ?>' style='color:black;'>Sign In</a> to add this business as your favorites.", "error");
            }
        });
    });
<?php if (trim($business['Business']['latitude']) != '' && trim($business['Business']['longitude']) != "") { ?>
        var lat = parseFloat("<?php echo trim($business['Business']['latitude']); ?>");
        var lng = parseFloat("<?php echo trim($business['Business']['longitude']); ?>");

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                scrollwheel: false,
                center: {lat: lat, lng: lng}
            });
            var geocoder = new google.maps.Geocoder();
            var marker = new google.maps.Marker({
                map: map,
                position: {lat: lat, lng: lng}
            });
            var infowindow = new google.maps.InfoWindow();
            google.maps.event.addListener(marker, 'mouseover', (function(marker) {
                var content = '<div class="newinfo"><img src="<?php echo $logo; ?>" alt="" height="100" width="100"/>';
                content += '<div class="icont"><b style="font-size:16px;"><?php echo h(trim($business['Business']['name'])); ?> </b>';
                content += '<p class="addr"><?php echo h(trim($business[0]['fulladdress'], ",")); ?> <br/><?php echo h(trim($business['Locality']['name'])); ?>, <?php echo h(trim($business['City']['name'])); ?> - <?php echo h(trim($business['Business']['pincode'])); ?></p>';
                content += '';
                content += '</div></div>';
                return function() {
                    if (!$('.togglemapicon').hasClass('fa-expand')) {
                        infowindow.setContent(content);
                        infowindow.open(map, marker);
                    }
                }
            })(marker));
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
                iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'background': 'rgb(238, 121, 69)'});

                // Moves the infowindow 115px to the right.
                // Reference to the div that groups the close button elements.
                var iwCloseBtn = iwOuter.next();

                // Apply the desired effect to the close button
                iwCloseBtn.css({opacity: '1', right: '33px', top: '3px', 'box-shadow': '0 0 5px #3990B9'});

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
<?php } ?>
    function toggleChevron(e) {
        $(e.target).closest('.panel').find('.indicator').toggleClass('ion-minus ion-plus');
    }
    $('#accordion').on('hidden.bs.collapse', toggleChevron);
    $('#accordion').on('shown.bs.collapse', toggleChevron);
</script>