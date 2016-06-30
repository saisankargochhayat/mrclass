<?php
echo $this->Html->css(array('bootstrap-datepicker.min'), array('block' => 'bootstrap_datatable_css'));
echo $this->Html->script(array('bootstrap-datepicker.min'), array('inline' => false));
?>
<section class="content-header">
    <h1><?php echo __('Add Transactions'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller'=>'subscriptions','action'=>'index','admin'=>1));?>">Subscriptions</a></li>
        <li class="active"><a href="<?php echo $this->Html->url(array('controller'=>'transactions','action'=>'index','admin'=>1,$user_id,$subscription_id));?>"><?php echo __('Transactions'); ?></a></li>
        <li><?php echo __('Add Transactions'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#transactionAdd" data-toggle="tab"><?php echo __('Add Transaction'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="transactionAdd">
                  <?php echo $this->Form->create('Transaction',array('action'=>'add','class'=>'form-horizontal','autocomplete' => 'off')); ?>
                        <div class="form-group">
                            <label for="TransactionUserId" class="col-sm-2 control-label"><?php echo __('Select User'); ?> *</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('user_id', array('options'=>$users,'selected' => $user_id,'label' => false, 'div' => false,'empty'=>__('Select User'),'class' => 'form-control','disabled'=>true)); ?>
                                <?php echo $this->Form->input('user', array('type' => 'hidden','value'=>$user_id));?>
                                <?php echo $this->Form->input('subscription_id', array('type' => 'hidden','value'=>$subscription_id));?>
				<div class="error" id="TransactionUserIdErr"></div>
                            </div>
                        </div>
                        <?php /*?><div class="form-group">
                            <label for="TransactionPackageId" class="col-sm-2 control-label"><?php echo __('Select Package'); ?> *</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('package_id', array('options'=>$packages,'label' => false, 'div' => false,'empty'=>__('Select Package'),'class' => 'form-control')); ?>
                                <div class="error" id="TransactionPackageIdErr"></div>
                            </div>
                        </div><?php */?>
                        <div class="form-group">
                            <label for="TransactionMode" class="col-sm-2 control-label"><?php echo __('Mode Of Transaction'); ?> *</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('mode', array('options'=>$modes,'label' => false, 'div' => false,'empty'=>__('Select Mode'),'class' => 'form-control')); ?>
                                <div class="error" id="TransactionModeErr"></div>
                            </div>
                        </div>
                        <?php /*?><div class="form-group">
                            <label for="TransactionReferenceNumber" class="col-sm-2 control-label"><?php echo __('Reference Number'); ?>*</label>
                            <div class="col-sm-10">
                          <?php echo $this->Form->input('reference_number',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'','class'=>'form-control','value'=>'MC'.mt_rand(0, 99999999),'readOnly'=>true));?>
                            </div>
                        </div><?php */?>
                        <div class="form-group">
                            <label for="TransactionIssuedDate" class="col-sm-2 control-label"><?php echo __('Date'); ?>*</label>
                            <div class="col-sm-10">
                          <?php echo $this->Form->input('issued_date',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'Select Date','class'=>'form-control','value'=>date('d/m/Y')));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="TransactionStatus" class="col-sm-2 control-label"><?php echo __('Status'); ?> *</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('status', array('options'=>$status,'label' => false, 'div' => false,'empty'=>__('Select Satus'),'class' => 'form-control')); ?>
                                <div class="error" id="TransactionStatusErr"></div>
                            </div>
                        </div>
						<div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-success" onclick="admin_add_transaction('');"><?php echo __('Submit'); ?></button>
                            </div>
                        </div>
                       <?php echo $this->Form->end(); ?>
                    </div><!-- /.tab-pane -->

                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
    jQuery(document).ready(function($) {
       $('#TransactionIssuedDate').datepicker({
            format: "dd/mm/yyyy",
            clearBtn: true,
            autoclose: true,
            todayHighlight: true
        }); 
    });
</script>
