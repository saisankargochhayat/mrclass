<style>
    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td{border: 0px none;}
    .actions{float: right;}
    .actions li{display: inline-block; list-type:none; border-right: 1px solid #333; padding-right: 5px;}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Package Details</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller'=>'packages','action'=>'index','admin'=>1));?>">Packages</a></li>
        <li class="active">View</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <div class="fr"><?php echo $this->Html->link(__('Edit Package'), array('action' => 'edit', $package['Package']['id']),array('class'=>'btn btn-block btn-primary')); ?></div>
        </div>
        <div class="box-body">
            <table class="table">
                <tbody>
                    <tr><td class="col-sm-2"><?php echo __('Name'); ?>:</td><td class="col-sm-10"><?php echo h($package['Package']['name']); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Price'); ?>:</td><td class="col-sm-10"><?php echo h($package['Package']['price']." p.m."); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Priority Search'); ?>:</td><td class="col-sm-10"><?php echo h(($package['Package']['priority_search'] == '1') ? 'Yes' : 'No'); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Personal Subdomain'); ?>:</td><td class="col-sm-10"><?php echo h(($package['Package']['personal_subdomain'] == '1') ? 'Yes' : 'No'); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Social Media Widget'); ?>:</td><td class="col-sm-10"><?php echo h(($package['Package']['social_media_widget'] == '1') ? 'Yes' : 'No'); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Map Integration'); ?>:</td><td class="col-sm-10"><?php echo h(($package['Package']['map_integration'] == '1') ? 'Yes' : 'No'); ?></td></tr>
                    <tr>
						<td class="col-sm-2"><?php echo __('Photo Limit'); ?>:</td>
						<td class="col-sm-10"><?php echo $this->Format->formatPackage($package['Package']['photo_limit'],'string');?></td>
					</tr>
                    <tr><td class="col-sm-2"><?php echo __('Video Limit'); ?>:</td>
						<td class="col-sm-10"><?php echo $this->Format->formatPackage($package['Package']['video_limit'],'string');?></td>
					</tr>
                    <tr><td class="col-sm-2"><?php echo __('Subscription'); ?>:</td>
						<td class="col-sm-10"><?php echo $this->Format->formatPackage($package['Package']['subscription'],'string');?></td>
					</tr>
                    <tr><td class="col-sm-2"><?php echo __('Listing Period'); ?>:</td><td class="col-sm-10"><?php echo h($package['Package']['listing_period']." days"); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Payment Method'); ?>:</td><td class="col-sm-10"><?php echo h($package['Package']['payment_method']); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Enquiries'); ?>:</td><td class="col-sm-10"><?php echo $this->Format->formatPackage($package['Package']['enquiries']);?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Address Detail'); ?>:</td><td class="col-sm-10"><?php echo h(($package['Package']['address_detail'] == '1') ? 'Yes' : 'No'); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Call Request'); ?>:</td><td class="col-sm-10"><?php echo h(($package['Package']['call_request'] == '1') ? 'Yes' : 'No'); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Review'); ?>:</td><td class="col-sm-10"><?php echo $this->Format->formatPackage($package['Package']['review']);?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Faq'); ?>:</td><td class="col-sm-10"><?php echo $this->Format->formatPackage($package['Package']['faq']);?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Status'); ?>:</td><td class="col-sm-10"><?php echo h(($package['Package']['status'] == '1') ? 'Active' : 'Inactive'); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Created'); ?>:</td><td class="col-sm-10"><?php echo strtotime($package['Package']['created']) > 0 ? $this->Format->dateFormat(h($package['Package']['created'])) : "---"; ?></td></tr>
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</section><!-- /.content -->