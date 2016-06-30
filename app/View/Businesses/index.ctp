<div class="booking_det">
    <div class="wrapper">
        <div class="content-left fl">
            <?php echo $this->element('user_inner_left_navbar'); ?>
        </div>
        <div class="fr upcom_book_cnt">
            <div class="up_mc_top my_bus">
                <h2>My Businesses</h2>
                <div class="fr"><?php echo $this->Html->link(__('User Dashboard'), array('controller' => 'users', 'action' => 'dashboard'), array('class' => 'cmn_btn_n')); ?></div>
                <div class="cb"></div>
            </div>           
            <div class="cnt_bx_upcom fl">
                <?php if (is_array($businesses) && count($businesses) > 0) { ?>
                    <?php foreach ($businesses as $key => $business): ?>
                        <?php
                        $seo_business_url = (!empty($is_subscribed) && intval($is_subscribed['Subscription']['personal_subdomain']) && ($is_subscribed['Subscription']['name'] == "Premium")) ? "Yes" : "No";
                        $business_url = $this->Format->business_detail_url($business['Business'], true, $seo_business_url);
                        ?>
                        <?php $business_id = h($business['Business']['id']); ?>
                        <div class="fl my_buisn cnt_innr_bus <?php echo $key % 2 === 1 ? "last" : ""; ?>">
                            <a class="full_block" title="<?php echo h($business['Business']['name']); ?>" href="<?php echo $business_url; ?>">
                                <div class="fl booking_img">
                                    <img src="<?php echo $this->Format->show_business_logo($business, 122, 122); ?>" alt=""/>
                                </div>
                                <div class="fl booking_cnt">
                                    <h3 class="ellipsis-view" rel="tooltip" title="<?php echo h($business['Business']['name']);?>">
                                        <?php echo h($business['Business']['name']); ?>
                                    </h3>
                                    <?php $business_address = trim($business['Business']['address']) != '' ? h($business['Business']['address']) . ", " : ""; ?>
                                    <?php $business_address .= trim($business['Business']['landmark']) != '' ? h($business['Business']['landmark']) . ", " : ""; ?>
                                    <?php $business_address .= h($business['Locality']['name']) . ", "; ?>
                                    <?php $business_address .= h($business['City']['name']) . ", "; ?>
                                    <?php $business_address .= h($business['Business']['pincode']); ?>
                                    <h4 class="ellipsis-view" rel="tooltip" title="<?php echo h(trim($business_address, ', ')); ?>">
                                        <span class="loct_cmn"></span>
                                        <?php echo h($business_address); ?>
                                    </h4>
                                    <h5><span class="ph_cmn"></span><?php echo $this->Format->formatPhoneNumber($business['Business']['phone']); ?></h5>
                                    <h6><span class="mail_cmn"></span><?php echo h($business['Business']['email']); ?></h6>
                                </div>						
                                <div class="cb"></div>
                                <div class="status_mybus">
                                    <?php /* <span class="aproved_icn"></span> <span class="unaproved_icn" title="Pending Admin Approval"></span> */ ?>
                                    <?php if ($business['Business']['status'] != '1') { ?>
                                        <span class="fa fa-warning" title="Not Approved"></span>
                                    <?php } ?>
                                </div>
                            </a>
                            <div class="my_bus_hov_icn">
                                <span class="fr bussiness-list-action-icons">
                                    <?php if ($business['Business']['type'] == 'private') { ?>
                                        <a class="ion ion-ios-locked " title="Private"></a>
                                    <?php } else { ?>
                                        <a class="fa fa-users " style="visibility:hidden;" title="Group"></a>
                                    <?php } ?>
                                    <a class="fa fa-edit" href="<?php echo $this->Html->url("/edit-business-" . $business_id); ?>"></a>
                                    <?php echo $this->Form->postLink('', array('action' => 'delete', $business['Business']['id']), array('class' => 'fa fa-trash-o', 'confirm' => __('Are you sure you want to delete - %s?', h($business['Business']['name'])))); ?>
                                </span>
                            </div>
                            <div class="cb"></div>
                        </div>
                        <?php echo $key % 2 === 1 ? '</div><div class="cnt_bx_upcom fl">' : ""; ?>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <div class="cnt_bx_upcom fl">
                        <div class="fl my_buisn cnt_innr_bus" style="width: 100%;text-align: center;">
                            <h3>No Business Found.</h3>
                            <h4><a href="<?php echo $this->Html->url(array('action' => 'add')); ?>">Create New Business</a></h4>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="cb"></div>
        </div>
        <div class="cb"></div>
    </div>
</div>
