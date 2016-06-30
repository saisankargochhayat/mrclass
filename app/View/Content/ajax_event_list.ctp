<?php $counter = 0; ?>
<?php if (is_array($events) && count($events) > 0) { ?>
    <?php foreach ($events as $key => $event) { ?>
        <?php
        $EventId = $event['Event']['id'];
        $EventUrl = $this->Format->event_detail_url($event['Event'], true);
        ?>
        <div class="fl link_cnt_mc viewitems list-cont-box relative cont_listing <?php echo ($counter % 4 == 3) ? ' last' : ''; ?>">
            <a title="<?php echo h($event['Event']['name']); ?>" href="<?php echo $EventUrl; ?>" rel="tooltip">
                <h2 class="ellipsis-view"><?php echo h($event['Event']['name']); ?></h2>
                <div class="cont_lis_img">
                    <?php
                    $zc = 0;
                    $image_url = $this->Format->show_event_banner($event, 312, 230, $zc);
                    ?>
                    <img data-original="<?php echo $image_url; ?>" alt="<?php echo h($event['Event']['name']); ?>" class="lazy" style="height:100%; width:100%;"/>
                </div>
                <h4 class="ellipsis-view" title="<?php echo h(trim($event[0]['fulladdress'], ",")); ?>" rel="tooltip">
                    <span class="loct_cmn"></span>
                    <span><?php echo h(trim($event[0]['fulladdress'], ",")); ?></span>
                </h4>
                <div class="rating_list_mc link_hide_list star-rating">
                    <div class="fl rating_star">
                        <span class="sub-head-dsc">Event on:</span>
                        <?php echo $this->Format->dateFormat(h($event['Event']['start_date'])); ?>
                        <?php echo $event['Event']['schedule_type'] == 'Specific' ? " to " . $this->Format->dateFormat(h($event['Event']['end_date'])) : ""; ?>
                    </div>
                    <div class="cb"></div>
                </div>
            </a>
        </div>
    <?php } ?>
    <?php if ($page == 1) { ?>
        <script type="text/javascript">$("#search_result_count_message").html("<?php echo $event_count; ?> Events found");</script>
    <?php } ?>
<?php } elseif ($page == 1) { ?>
    <div class="norecord"><center>Oops, nothing in this area yet. New events are coming soon. Please check back later.</center></div>
<?php } ?>
<?php if ($view_loadmore == 'Yes') { ?>
    <div class="loadmore" id="load_more_record"><center>Load more...</center></div>
<?php } ?>
