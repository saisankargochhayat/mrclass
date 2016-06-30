<?php echo $this->Form->create('businesses', array('action' => 'business_reports_sheets', 'admin' => 1, 'type' => 'get')); ?>
<input type="hidden" name="mode" id="" value="all" />
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><?php echo __('Export Businesses'); ?></h4>
</div>
<div class="modal-body" style="height:90px;">
    <div class="col-lg-12">
        <div class="col-lg-3">
            <div class="form-group">
                <?php echo $this->Form->input('city_id', array('options' => $cities, 'empty' => __('All City'), 'class' => 'form-control select2 import', 'div' => false, 'label' => false, 'id' => 'city_export')); ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo $this->Form->input('category_id', array('options' => $categorie_ids, 'empty' => __('All Category'), 'class' => 'form-control select2 import', 'div' => false, 'label' => false, 'id' => 'category_export')); ?>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <?php echo $this->Form->input('plan_id', array('options' => $packages, 'empty' => __('All Packages'), 'class' => 'form-control select2 import', 'div' => false, 'label' => false, 'id' => 'plan_export')); ?>
            </div>
        </div>
        <div class="col-lg-2">
            <button type="submit" id="export_custom" class="btn btn-primary"><?php echo __('Export'); ?></button>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php /* <div class="col-lg-12" style="text-align: center;height: 30px;">--- OR ---</div>
      <div class="col-lg-12" style="text-align: center;">
      <button type="submit" id="submit_export" class="btn btn-primary btn-block" onclick="return reset_filter();">
      <?php echo __('Export All'); ?>
      </button>
      </div> */ ?>
</div>
<div class="modal-footer" style="height:40px;">
</div>
<?php echo $this->Form->end(); ?>
<script>
    $(".select2").select2();
    // function check_filter(){
    //      var flag = true;
    //     $('.import').each(function(index, el) {
    //         if($(el).val() > 0){
    //             flag = false;
    //         }
    //     });
    //     if(flag){
    //         alert('Please select city or category to export !')
    //     }
    //     return (!flag) ? true : false;
    // }
    // function reset_filter(){
    //     $('.import').each(function(index, el) {
    //         $(el).select2("val", "");
    //     });
    // }
</script>
