<?php 
if(!empty($transaction['Transaction']['discount'])){
    if($transaction['Transaction']['sub_total'] < $transaction['Transaction']['discount']){
       $label_text = "Carry Forward Balance"; 
       $total_text = "Total Refund";
    }else{
        $label_text = "Discount";
        $total_text = "Total Price";
    }
}else{
    $label_text = "Discount";
    $total_text = "Total Price";
}
?>
<style>
    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td{border: 0px none;}
    .actions{float: right;}
    .actions li{display: inline-block; list-type:none; border-right: 1px solid #333; padding-right: 5px;}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Transaction Details</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller'=>'subscriptions','action'=>'index','admin'=>1));?>">Subscriptions</a></li>
	<li><a href="<?php echo $this->Html->url(array('controller'=>'transactions','action'=>'index','admin'=>1,$userid,$subid));?>">Transactions</a></li>
        <li class="active">Details</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">Details</div>
        <div class="box-body">
            <table class="table">
                <tbody>
                    <tr><td class="col-sm-2"><?php echo __('User Name'); ?>:</td><td class="col-sm-10"><?php echo h($transaction['User']['name']); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Package'); ?>:</td><td class="col-sm-10"><?php echo h($transaction['Subscription']['name']); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Payment Mode'); ?>:</td><td class="col-sm-10"><?php echo h($transaction['Transaction']['mode']); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Sub-total Price'); ?>:</td><td class="col-sm-10"><?php echo h($transaction['Transaction']['sub_total']); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo $label_text; ?>:</td><td class="col-sm-10"><?php echo h($transaction['Transaction']['discount']); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo $total_text; ?>:</td><td class="col-sm-10"><?php echo h($transaction['Transaction']['final_price']); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Reference Number'); ?>:</td><td class="col-sm-10"><?php echo h($transaction['Transaction']['reference_number']); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Subscription Date'); ?>:</td><td class="col-sm-10"><?php echo h($this->Format->dateFormat($transaction['Subscription']['created'])); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Status'); ?>:</td><td class="col-sm-10"><?php echo h($transaction['Transaction']['status']); ?></td></tr>
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</section><!-- /.content -->