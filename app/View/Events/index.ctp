<div class="booking_det">
    <div class="wrapper">
        <div class="content-left fl">
            <?php echo $this->element('business_left_tab'); ?>
        </div>
        <div class="fr upcom_book_cnt">
            <div class="up_mc_top my_bus">
                <h2>My Events</h2>
                <div class="fr">
                    <?php echo $this->Html->link(__('User Dashboard'), array('controller' => 'users', 'action' => 'dashboard'), array('class' => 'cmn_btn_n')); ?>
                </div>
                <div class="fr" style="margin-right:10px">
                    <?php echo $this->Html->link(__('Create New Event'), array('controller' => 'events', 'action' => 'add'), array('class' => 'cmn_btn_n')); ?>
                </div>
                <div class="cb"></div>
            </div>           
            <div class="cnt_bx_upcom fl">
                <?php if (is_array($events) && count($events) > 0) { ?>
                    <?php foreach ($events as $key => $event): ?>
                        <?php $event_url = $this->Format->event_detail_url($event['Event']); ?>
                        <?php $event_id = $event['Event']['id']; ?>
                        <div class="fl my_buisn cnt_innr_bus <?php echo $key % 2 === 1 ? "last" : ""; ?>">
                            <a class="full_block" title="<?php echo h($event['Event']['name']); ?>" href="<?php echo $event_url; ?>">
                                <div class="fl booking_img">
                                    <img src="<?php echo $this->Format->show_event_banner($event, 122, 122); ?>" alt=""/>
                                </div>
                                <div class="fl booking_cnt">
                                    <h3 class="ellipsis-view" rel="tooltip" title="<?php echo h($event['Event']['name']); ?>">
                                        <?php echo h($event['Event']['name']); ?>
                                    </h3>
                                    <?php $event_address = trim($event['Event']['address']) != '' ? h($event['Event']['address']) . ", " : ""; ?>
                                    <?php $event_address .= trim($event['Event']['landmark']) != '' ? h($event['Event']['landmark']) . ", " : ""; ?>
                                    <?php $event_address .= h($event['Locality']['name']) . ", "; ?>
                                    <?php $event_address .= h($event['City']['name']) . ", "; ?>
                                    <?php $event_address .= h($event['Event']['pincode']); ?>
                                    <h4 class="ellipsis-view" rel="tooltip" title="<?php echo h(trim($event_address, ', ')); ?>">
                                        <span class="loct_cmn"></span>
                                        <?php echo h($event_address); ?>
                                    </h4>
                                    <h5><span class="ph_cmn"></span><?php echo $this->Format->shortLength($this->Format->maskMobile($event['Event']['phone'], 'X'), 23, $this->Format->maskMobile($event['Event']['phone'], 'X')); ?></h5>
                                    <h6><span class="mail_cmn"></span><?php echo $this->Format->shortLength($this->Format->mask_email($event['Event']['email'], 'X', 100), 23, $this->Format->mask_email($event['Event']['email'], 'X', 100)); ?></h6>
                                </div>						
                                <div class="cb"></div>
                                <div class="status_mybus">
                                    <?php if ($event['Event']['status'] != '1') { ?>
                                        <span class="fa fa-warning" title="Event is not active"></span>
                                    <?php } ?>
                                </div>
                            </a>
                            <div class="my_bus_hov_icn">
                                <span class="fr bussiness-list-action-icons">
                                    <a class="fa fa-edit" href="<?php echo $this->Html->url("/edit-event-" . $event_id); ?>"></a>
                                    <?php echo $this->Form->postLink('', array('action' => 'delete', $event_id), array('class' => 'fa fa-trash-o', 'confirm' => __('Are you sure you want to delete - %s?', h($event['Event']['name'])))); ?>
                                </span>
                            </div>
                            <div class="cb"></div>
                        </div>
                        <?php echo $key % 2 === 1 ? '</div><div class="cnt_bx_upcom fl">' : ""; ?>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <div class="cnt_bx_upcom fl">
                        <div class="fl my_buisn cnt_innr_bus" style="width: 100%;text-align: center;">
                            <h3>No Events Found.</h3>
                            <h4><a href="<?php echo $this->Html->url(array('controller' => 'events', 'action' => 'add')); ?>">Create New Event</a></h4>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="cb"></div>
        </div>
        <div class="cb"></div>
    </div>
</div>
