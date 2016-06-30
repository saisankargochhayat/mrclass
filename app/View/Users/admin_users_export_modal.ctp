<?php

echo $this->Form->create('users',array('action' => 'user_reports_sheets','admin'=>1,'type'=>'get')); ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><?php echo __('Export Users Information'); ?></h4>
</div>
<div class="modal-body" style="height:90px;">
    <div class="col-lg-12">
        <div class="col-lg-8">
            <div class="form-group">
        <?php echo $this->Form->input('city_id', array('options' => $cities,'empty' => __('All City'),'class' => 'form-control select2 import', 'div' => false, 'label' => false,'id'=>'city_export'));?>
            </div>
        </div>
        <input type="hidden" name="mode" id="" value="all" />
        <div class="col-lg-4">
            <button type="submit" id="export_custom_users" class="btn btn-primary btn-block">
                <?php echo __('Export'); ?>
            </button>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php /*<div class="col-lg-12" style="text-align: center;height: 30px;">--- OR ---</div>
    <div class="col-lg-12" style="text-align: center;">
        <button type="submit" id="submit_export_all" class="btn btn-primary" onclick="return reset_filter();">
                <?php echo __('Export All'); ?>
        </button>
    </div>*/?>
</div>
<div class="modal-footer" style="height:40px;">
</div>
<?php echo $this->Form->end(); ?>
<script>
    // $(".select2").select2();
    // function check_filter(){
    //     if(!$('.import').val()){
    //         alert('Please select city to export !')
    //     }
    //     return ($('.import').val()) ? true : false;
    // }
    // function reset_filter(){
    //    $('.import').select2("val", "");
    // }
</script>
