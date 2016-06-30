<?php echo $this->Form->create('subscriptions', array('action' => 'export_reports_sheets', 'admin' => 1, 'type' => 'get')); ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><?php echo __('Export Subscriptions'); ?></h4>
</div>
<div class="modal-body" style="height:90px;">
    <div class="col-lg-12">
        <div class="col-lg-8">
            <div class="form-group">
                <?php echo $this->Form->input('plan_id', array('options' => $packages, 'empty' => __('All Packages'), 'class' => 'form-control select2 import', 'div' => false, 'label' => false, 'id' => 'plan_export')); ?>
            </div>
        </div>
        <div class="col-lg-4">
            <button type="submit" id="export_custom" class="btn btn-primary"><?php echo __('Export'); ?></button>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="modal-footer" style="height:40px;"></div>
<?php echo $this->Form->end(); ?>
<script type="text/javascript">$(".select2").select2();</script>
