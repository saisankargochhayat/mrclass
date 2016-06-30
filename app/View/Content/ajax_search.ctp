<?php $counter = 0; ?>
<?php if (is_array($searchData) && count($searchData)>0) { ?>
    <?php if ($view != 'list') { ?>
        <div class="list_det_cnt viewblocks gridviewblock" style="padding-top:0px;">
    <?php } else { ?>
        <div class="list_det_cnt grid_view_cnt viewblocks <?php echo $view != 'list' ? "none" : ""; ?> listviewblock">
    <?php } ?>
        <?php foreach ($ads as $key => $addata) { ?>
            <div class="fl link_cnt_mc viewitems list-cont-box relative effects_grid cont_listing adblocks <?php echo ($counter % 4 == 3) ? ' last' : ''; ?> <?php echo $counter % 4;?>">
                <a class="" href="<?php echo $addata['Advertisement']['url']!=""?$addata['Advertisement']['url']:"javascript://";?>" target="_blank">
                    <?php if ($view != 'list') { ?>
                        <img src="<?php echo $this->Format->ad_image($addata['Advertisement'], 250, 290, 0); ?>" alt="" style=""/>
                    <?php }else{ ?>
                        <img src="<?php echo $this->Format->ad_image($addata['Advertisement'], 960, 260, 0); ?>" alt="" style=""/>
                    <?php } ?>
                </a>
            </div>
            <?php $counter++; ?>
        <?php } ?>
        <?php $markers = array(); ?>
        <?php foreach ($searchData as $key => $data) { ?>
            <?php $BusinessId = $data['Business']['id']; ?>
            <?php
            $allowed = (!empty($data['Subscription']['personal_subdomain']) && intval($data['Subscription']['personal_subdomain']) && ($data['Subscription']['name'] == "Premium")) ? "Yes" : "No";
            $BusinessUrl = $this->Format->business_detail_url($data['Business'], true, $allowed);
            ?>
            <?php
            $markers[] = array('latitude' => $data['Business']['latitude'], 'longitude' => $data['Business']['longitude'],
                'name' => h($data['Business']['name']), 'address' => h(trim($data[0]['fulladdress'], ",")),
                'logo' => $this->Format->show_business_logo($data, 122, 122, 0), 'link' => $BusinessUrl);
            ?>
            <?php if ($view != 'list') { ?>
                <div class="fl link_cnt_mc viewitems list-cont-box relative effects_grid cont_listing<?php echo ($counter % 4 == 3) ? ' last' : ''; ?> <?php echo $counter % 4;?>">
                    <a title="<?php echo h($data['Business']['name']); ?>" href="<?php echo $BusinessUrl; ?>" rel="tooltip">
                        <h2 class="ellipsis-view">
                            <?php echo h($data['Business']['name']); ?>
                            <?php /*if($data['Business']['type'] == 'private'){ ?>
                                <i class="ion ion-ios-locked business_type_icon" title="Private"></i>
                            <?php }else{ ?>
                                <i class="fa fa-users business_type_icon" style="visibility:hidden;" title="Group"></i>
                            <?php } */?>
                        </h2>
                        <div class="cont_lis_img">
                            <?php $zc = 0;
                                if(trim($data['Business']['logo'])!=''){
                                    $image_url = $this->Format->show_business_logo($data, 312, 230, $zc);
                                }elseif (isset($data['BusinessGallery']) && is_array($data['BusinessGallery']) && count($data['BusinessGallery']) > 0) {
                                    $image_url = $this->Format->gallery_image($data, $BusinessId, 312, 230, $zc);
                                }else{
                                    $image_url = $this->Format->show_business_logo($data, 312, 230, $zc);
                                }
                            ?>
                            <img data-original="<?php echo $image_url; ?>" alt="<?php echo h($data['Business']['name']); ?>" class="lazy" style="height:100%; width:100%;"/>

                        </div>
                       <h4 class="ellipsis-view" title="<?php echo h(trim($data[0]['fulladdress'], ",")); ?>" rel="tooltip">
                            <span class="loct_cmn"></span>
                            <span><?php echo h(trim($data[0]['fulladdress'], ",")); ?></span>
                        </h4>			
                        <?php /*?><h5>
                        <span class="ph_cmn"></span><?php echo $this->Format->formatPhoneNumber($data['Business']['phone']); ?>
                        <span class="ph_cmn"></span><?php echo $this->Format->maskMobile($this->Format->formatPhoneNumber($data['Business']['phone']),'x'); ?>
                        </h5><?php */?>
                        <?php /*?><h6 class="ellipsis-view" title="<?php echo $this->Format->mask_email($data['Business']['email'],'x',100); ?>">
                            <span class="mail_cmn"></span>
                            <span><?php echo h($data['Business']['email']); ?></span>
                            <span><?php echo $this->Format->mask_email($data['Business']['email'],'x',100); ?></span>
                        </h6><?php */?>
                        <div class="rating_list_mc link_hide_list star-rating">
                            <div class="fl lft_icn">
                                <?php if(is_array($data['Facility']) &&  count($data['Facility'])>0) { ?>
                                    <?php $icon_count = 0;?>
                                        <?php foreach ($data['Facility'] as $facility) { ?>
                                        <span title="<?php echo h($facility['name']);?>" class="anchor <?php echo strtolower(h($facility['name']));?>">
                                            <?php echo $this->Format->format_facility_icon($facility['image'],'icon-user-grid'); ?>
                                        </span>
                                        <?php $icon_count++; ?>
                                        <?php if($icon_count==4) break; ?>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="fr rating_star">
                                <?php $rating = isset($data[0]['rating']) ? $data[0]['rating'] : 0; ?>
                                <?php $reviews_count = isset($data[0]['reviews_count']) ? $data[0]['reviews_count'] : 0; ?>
                                    <?php echo $this->element('view_rating', array('rating' => $rating, 'reviews_count' => $reviews_count,'element'=>'span')) ?>
                                &nbsp;
                            </div>
                            <div class="cb"></div>
                        </div>
                    </a>
                </div>
            <?php } else { ?>
                <div class="cont_listing viewitems effects_list">
                    <div class="">
                        <div class="fl relative" style="max-width:80%;">
                            <h2 class="ellipsis-view" style="">
                                <a title="<?php echo h($data['Business']['name']); ?>" href="<?php echo $BusinessUrl; ?>" rel="tooltip">
                                    <?php echo h($data['Business']['name']); ?>
                                    <span class="listview_businesstype">
                                        <?php if($data['Business']['type'] == 'private'){ ?>
                                            <i class="fa fa-user " title="Private"></i>
                                        <?php }else{ ?>
                                            <i class="fa fa-users " style="visibility:hidden;" title="Group"></i>
                                        <?php } ?>
                                    </span>
                                </a>
                            </h2>
                        </div>
                        <div class="fr rating_star">
                            <?php $rating = isset($data[0]['rating']) ? $data[0]['rating'] : 0; ?>
                            <?php $reviews_count = isset($data[0]['reviews_count']) ? $data[0]['reviews_count'] : 0; ?>
                                <?php echo $this->element('view_rating', array('rating' => $rating, 'reviews_count' => $reviews_count,'element'=>'span')) ?>
                        </div>
                        <div class="cb"></div>
                    </div>
                    <div>
                        <div class="fl list_view_lft_cnt">
                            <h4 class="ellipsis-view" rel="tooltip" title="<?php echo h(trim($data[0]['fulladdress'], ",")); ?>">
                                <span class="loct_cmn"></span><?php echo h(trim($data[0]['fulladdress'], ",")); ?>
                            </h4>
                            
                            <?php /*?><h5><span class="ph_cmn"></span><?php echo $this->Format->maskMobile($this->Format->formatPhoneNumber($data['Business']['phone']),'x'); ?></h5>
                            <h6><span class="mail_cmn"></span><a><?php echo $this->Format->mask_email($data['Business']['email'],'x',100); ?></a></h6><?php */?>
                        </div>
                        <?php $gallery = $data['BusinessGallery'];?>
                            <?php if(is_array($gallery) && count($gallery)>0){ ?>
                            <?php if((count($gallery) <= 4) && (count($gallery) > 1)){
                                $width = "style='width:".((count($gallery) * 10) + 1)."%'";
                            }else if((count($gallery) == 1)){
                                $width = "style='width:".((count($gallery) * 10) + 4)."%'";
                            }else{
                                $width = "style='width:".((5 * 10) - 2)."%'";
                            }?>
                            <div class="fr slde_img_cont_list" <?php echo $width;?>>
                                <div class="jcarousel-wrapper">
                                    <div class="jcarousel">
                                        <ul>
                                            <?php foreach($gallery as $key1=>$gal){?>
                                                <li>
                                                    <a class="colorbox" rel="gallery<?php echo $BusinessId;?>" data-href="<?php echo $this->Format->gallery_image($gal,$BusinessId, '800', '600',2); ?>">
                                                        <img src="<?php echo $this->Format->gallery_image($gal,$BusinessId,70,53,0); ?>" alt=""/>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <?php if(count($gallery) > 4){?>
                                        <a class="jcarousel-control-prev anchor"></a>
                                        <a class="jcarousel-control-next anchor"></a>
                                    <?php }?>
                                </div>
                            </div>
                        <?php }else{ ?>
                            <div class="fr slde_img_cont_list_logo">
                            <a class="colorbox" rel="gallery<?php echo $BusinessId;?>" data-href="<?php echo $this->Format->show_business_logo($data, 800, 600, 2); ?>">
                                <img src="<?php echo $this->Format->show_business_logo($data, 100, 100, 0); ?>" alt="<?php echo h($data['Business']['name']); ?>" style="height:100px; width:100px;"/>
                                </a>
                            </div>
                        <?php } ?>
                        <div class="cb"></div>
                    </div>
                    <div class="rating_list_mc">
                       <div class="fl lft_icn list">
                            <?php foreach ($data['Facility'] as $facility) { ?>
                                <a title="<?php echo h($facility['name']);?>" class="anchor <?php echo strtolower(h($facility['name']));?>">
                                    <?php echo $this->Format->format_facility_icon($facility['image'],'icon-user-list'); ?>
                                </a>
                            <?php } ?>
                        </div>
                        <div class="fr rating_star str_cnt_grid">
                            <?php if($reviews_count > 0){?>
                            <span><?php echo $reviews_count;?></span> Review(s)
                            <?php } ?>
                        </div>
                        <div class="cb"></div>
                    </div>
                </div>
            <?php } ?>
            <?php $counter++; ?>
        <?php } ?>
        <div class="cb"></div>
    </div>
    <script>$('#map').show();$('.searchresultsummary').css('visibility','visible');</script>
<?php }elseif($page == 1){?>
    <div class="norecord"><center>Oops, nothing in this area yet. But we are adding Businesses everyday. Please check back later.</center>
        <script>Search.clearMarkers();</script>
    </div>
<?php } ?>
<?php if($view_loadmore == 'Yes'){?>
    <div class="loadmore" id="load_more_record"><center>Load more...</center></div>
<?php } ?>

<script type="text/javascript">
        var max_distance = '';
        var max_price = '';
        var min_price = '';
        var mark_points = '';
        var facilities = '';
    <?php if(!empty($max_distance)){?>
         max_distance = '<?php echo floor($max_distance[0]['distance']);?>';
         max_price = '<?php echo ($max_distance[0]['max_price']);?>';
         min_price = '<?php echo ($max_distance[0]['min_price']);?>';
    <?php } ?>

    <?php if(!empty($location_data) && is_array($location_data) && count($location_data)>0){
        $markers = array();
        foreach($location_data as $key => $data){
            $BusinessUrl = $this->Format->business_detail_url($data['Business']);
            $markers[] = array('latitude' => $data['Business']['latitude'], 'longitude' => $data['Business']['longitude'],
                    'name' => h($data['Business']['name']), 'address' => h(trim($data[0]['fulladdress'], ",")),
                    'logo'=>$this->Format->show_business_logo($data, 100, 100,0), 'link' => $BusinessUrl);
        }
        ?>
         mark_points = '<?php echo json_encode($markers);?>';
    <?php } ?>
    <?php if(!empty($facilities) && is_array($facilities) && count($facilities)>0){?>
         facilities = '<?php echo json_encode(($facilities));?>';
    <?php } ?>
    <?php if(!empty($page) && intval($page)<2){?>
        $("#search_result_count_message").html("<?php echo intval($count_data) . ($count_data>1 ?" Businesses":" Business")." found" ;?>")
    <?php } ?>
</script>