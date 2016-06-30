<style type="text/css">
.price_blocks{padding: 6px 13px;background: grey;width: 47%;text-align: center;color: #fff;border-radius: 4px;}
</style>
<?php
$day_digit_array = array_combine(range(1,24),range(1,24));
$block_count = (count($discounts) > 0) ? count($discounts) : 1;
?>
<section class="content-header">
    <h1><?php echo __('Update Discounts For: '.$package_data['Package']['name']); ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">
            <a href="<?php echo $this->Html->url(array('controller'=>'packages','action'=>'index','admin'=>1));?>">
                <?php echo __('Packages'); ?>
            </a>
        </li>
        <li>
            <?php echo __('Edit Package'); ?>
        </li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="">
                        <a href="<?php echo $this->Html->url(array("controller" =>"packages","action" =>"edit","admin" => 1,$package_id)); ?>"><?php echo __( 'Edit Package'); ?></a>
                    </li>
                    <li class="<?php if($parms['controller'] == 'package_discounts' && $parms['action'] == 'admin_edit'){ echo 'active';}else{echo '';}?>">
                        <a href="<?php echo $this->Html->url(array("controller" => "package_discounts", "action" => "edit", "admin" => 1,$package_id)); ?>">
                            <?php echo __( 'Package Offers'); ?>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="packagediscountEdit">
                     <?php echo $this->Form->create('PackageDiscount',array('action' => 'edit'),array('class'=>'form-horizontal','autocomplete' => 'off')); ?>
                        <input name="data[PackageDiscount][package_id]" value="<?php echo $package_id;?>" type="hidden" />
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Discounts</h3>
                            </div>
                            <div class="box-body pad table-responsive">
                                <div id="wrapper_table_div">
                                <?php if (count($discounts) > 0) { ?>
                                <?php $cntr = 0;
                                foreach ($discounts as $key => $value){ ?>
                                <fieldset data-legendid="<?php echo $key + 1;?>" class="discount_legend">
                                <legend>Offer <?php echo $cntr + 1;?></legend>
                                <table class="table text-center discount_table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label for="" class="col-sm-4 control-label">
                                                        <?php echo __( 'Period'); ?>*</label>
                                                    <input name="data[PackageDiscount][<?php echo $key;?>][id]" value="<?php echo @$value['PackageDiscount']['id'];?>" type="hidden" />
                                                    <input name="data[PackageDiscount][<?php echo $key;?>][package_id]" value="<?php echo $package_id;?>" type="hidden" />
                                                    <div class="col-sm-8">
                                                        <?php echo $this->Format->create_selectbox("data[PackageDiscount][".$key."][period_duration]", $day_digit_array, $value['PackageDiscount']['period_duration'], 'class="form-control discount_inputs total_price"','','');?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <label for="" class="col-sm-4 control-label">
                                                        <?php echo __( 'Period Type'); ?>*</label>
                                                    <div class="col-sm-8">
                                                        <?php echo $this->Format->create_selectbox("data[PackageDiscount][".$key."][period_type]", array("Month"=>"Month","Year"=>"Year"), $value['PackageDiscount']['period_type'], 'class="form-control discount_inputs total_price"','','');?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td rowspan="2" style="vertical-align:middle" align="left">
                                                <?php if($cntr > 0){?>
                                               <a class="btn btn-social-icon btn-google remove_button" rel="tooltip" data-urlId="<?php echo @$value['PackageDiscount']['id'];?>" title="Remove Discount"><i class="ion-minus-circled"></i></a>
                                                <?php }?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label for="" class="col-sm-4 control-label">Discount Amount*</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" name="data[PackageDiscount][<?php echo $key;?>][discount]" class="form-control numbersOnly discount_inputs discount_price" min="0" step="1"placeholder="Enter discount" value="<?php echo @$value['PackageDiscount']['discount'];?>">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <label for="" class="col-sm-4 control-label">
                                                        <?php echo __( 'Discount Type'); ?>*</label>
                                                    <div class="col-sm-8">
                                                        <?php echo $this->Format->create_selectbox("data[PackageDiscount][".$key."][discount_type]", array("Month"=>"Month","Flat"=>"Flat","Percentage"=>"Percentage"), $value['PackageDiscount']['discount_type'], 'class="form-control discount_inputs discount_price"','','');?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                    <div class="box-footer" style="margin:0px auto;width:40%;">
                                            <div class="col-sm-4 price_blocks total_text" style="margin-right:2%;">
                                              Total Price : <span id="total_price_spn_<?php echo $key+1;?>"><?php echo floatval($value['PackageDiscount']['total_price']);?></span>
                                            </div>
                                            <div class="col-sm-4 price_blocks discount_text">
                                              Discounted Price : <span id="discount_price_spn_<?php echo $key+1;?>"><?php echo floatval($value['PackageDiscount']['discounted_price']);?></span>
                                            </div>
                                    </div>
                                </fieldset>
                                <?php $cntr++; ?>
                                <?php } ?>
                                <?php } else { ?>
                                <fieldset class="discount_legend" data-legendid="1">
                                <legend>Offer 1</legend>
                                <table class="table text-center discount_table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-4 control-label">
                                                            <?php echo __('Period'); ?>*</label>
                                                        <input name="data[PackageDiscount][0][id]" value="" type="hidden" />
                                                        <input name="data[PackageDiscount][0][package_id]" value="<?php echo $package_id; ?>" type="hidden" />
                                                        <div class="col-sm-8">
                                                            <?php echo $this->Format->create_selectbox("data[PackageDiscount][0][period_duration]", $day_digit_array, '', 'class="form-control discount_inputs total_price"', '', ''); ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-4 control-label">
                                                            <?php echo __('Period Type'); ?>*</label>
                                                        <div class="col-sm-8">
                                                            <?php echo $this->Format->create_selectbox("data[PackageDiscount][0][period_type]", array("Month" => "Month", "Year" => "Year"), '', 'class="form-control discount_inputs total_price"', '', ''); ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td rowspan="2" style="vertical-align:middle" align="left">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-4 control-label">Discount Amount*</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" name="data[PackageDiscount][0][discount]" class="form-control numbersOnly discount_inputs discount_price" placeholder="Enter discount" min="0" step="1">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-4 control-label"><?php echo __('Discount Type'); ?>*</label>
                                                        <div class="col-sm-8">
                                                            <?php echo $this->Format->create_selectbox("data[PackageDiscount][0][discount_type]", array("Month" => "Month", "Flat" => "Flat", "Percentage" => "Percentage"), '', 'class="form-control discount_inputs discount_price"', '', ''); ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="box-footer" style="margin:0px auto;width:40%;">
                                        <div class="col-sm-4 price_blocks total_text" style="margin-right:2%;">
                                            Total Price : <span id="total_price_spn_1"><?php echo floatval($package_data['Package']['price']);?></span>
                                        </div>
                                        <div class="col-sm-4 price_blocks discount_text">
                                            Discounted Price : <span id="discount_price_spn_1">0</span>
                                        </div>
                                    </div>
                                </fieldset>
                                <?php } ?>
                                </div>
                                <?php if($package_data['Package']['id'] != '1'){?>
                                <div class="box-footer" style="margin-right: 12px;">
                                    <div class="input-group pull-right">
                                      <a class="btn btn btn-success btn-social-icon add_button" rel="tooltip" title="Add Discount"><i class="ion-plus-circled"></i></a>
                                    </div>
                                </div>
                                <?php }?>
                            </div>
                            <div class="box-footer">
                                <div class="input-group">
                                  <button type="button" onclick="submit_discount_form();" class="btn btn-block btn-success btn-flat">Save</button>
                                </div>
                              </div>
                            <!-- /.box -->
                              <div class="overlay" style="display:none;">
                                <i class="fa fa-refresh fa-spin"></i>
                              </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<script type="text/javascript">
var addButton;
var wrapper;
var remove_button;
var fieldHTML;
var block_id;
var discount_limit = 20;
var package_price = parseInt("<?php echo $package_data['Package']['price'];?>") || 0;
var counter = ((parseInt("<?php echo count($discounts); ?>")) ? parseInt("<?php echo count($discounts); ?>") - 1 : 0) || 0;
var block_count = parseInt("<?php echo $block_count;?>");
var fieldHTML;
var fieldHTML_block;
$(document).ready(function() {
    addButton = $('.add_button');
    wrapper = $('#wrapper_table_div');
    remove_button = '<a class="btn btn-social-icon btn-google remove_button" rel="tooltip" title="Remove Discount"><i class="ion-minus-circled"></i></a>';
    fieldHTML_block = $(wrapper).find('.discount_legend').eq(0).clone();
    $(addButton).on('click', function() {
        fieldHTML = fieldHTML_block.clone();
        $(fieldHTML).find('tr:eq(0) td:eq(2)').html(remove_button);
        if (counter == discount_limit) {
            alert('Sorry ! you can not add more discounts.', 'error');
        }
        if (counter < discount_limit) {
            counter++;
            block_count++;
            var sel = $(fieldHTML).find('.form-group');
            $(fieldHTML).find('legend').text('Offer ' + block_count);
            $(fieldHTML).find('.discount_text span').attr('id', 'discount_price_spn_' + block_count);
            $(fieldHTML).find('.total_text span').attr('id', 'total_price_spn_' + block_count);
            $(fieldHTML).find('.discount_text span').text('0');
            $(fieldHTML).attr('data-legendid', block_count);
            $(fieldHTML).find('.total_text span').text(package_price);
            $(sel).find("select,input[type='number']").val('');
            $(sel).find("input[type='hidden'][name$='[id]']").val('');
            $(sel).find('input,select').each(function() {
                var type = $(this).attr('type');
                var oldname = $(this).attr('name');
                if (typeof oldname !== 'undefined') {
                    var newname = oldname.replace(/\d+/, block_count);
                    $(this).attr('name', newname);
                }
            });
            $(wrapper).append(fieldHTML);
        }
        update_counters();
    });
    $(wrapper).on('click', '.remove_button', function(e) {
        var _this = $(this);
        var attr = _this.attr('data-urlId');
        if (typeof attr !== 'undefined' && typeof attr !== false) {
            if (confirm("Are You Sure want to delete the package discount ?")) {
                $('.overlay').show();
                $.ajax({
                    type: "POST",
                    data: {
                        id: attr
                    },
                    url: "<?php echo $this->Html->url(array('controller' => 'package_discounts', 'action' => 'delete', 'admin' => 1)); ?>",
                    success: function(response) {
                        if (response) {
                            $('.overlay').hide();
                            if (response == "Success") {
                                _this.closest('fieldset').remove();
                            } else {
                                alert('Package discount could not be deleted.');
                            }
                        }
                    }
                });
            }
        } else {
            $(this).closest('fieldset').remove();
        }
        counter--;
        update_counters();
    });
    $(wrapper).on('change', '.discount_inputs', function(e) {
    var block,period,period_type,total_months,total_price,discount_amount,discount_type,total_discounted_price;
        block_id = $(this).closest('fieldset').attr('data-legendid');
        block = $(this).closest('fieldset');
        period = parseInt($(block).find('.total_price').eq(0).val());
        period_type = $(block).find('.total_price').eq(1).val();
        total_months = (period_type == "Year") ? period * 12 : period;
        total_price = package_price * total_months;
        discount_amount = isNaN(parseInt($(block).find('.discount_price').eq(0).val())) ? 0 : parseInt($(block).find('.discount_price').eq(0).val());
        discount_type = $(block).find('.discount_price').eq(1).val();
        if (discount_type == "Flat") {
            total_discounted_price = total_price - discount_amount;
        } else if (discount_type == "Percentage") {
            total_discounted_price = total_price - ((discount_amount / 100) * total_price);
        } else {
            total_discounted_price = total_price - (package_price * discount_amount);
        }
        $('#total_price_spn_' + block_id).text(total_price);
        total_discounted_price = isNaN(total_discounted_price) ? 0 : ((total_discounted_price > 0) ? parseFloat(Math.round(total_discounted_price * 100) / 100) : 0);
        $('#discount_price_spn_' + block_id).text(total_discounted_price);
    });
});

function submit_discount_form() {
    var error_arr = [];
    var error_string_alert = "Please enter discount amount at offer ";
    $('.numbersOnly').each(function(index, el) {
        var _this = $(this);
        if (!_this.val()) {
            error_arr.push(index + 1);
        }
    });
    if (error_arr.length > 0) {
        for (var i = 0; i < error_arr.length; i++) {
            error_string_alert += error_arr[i] + " & ";
        }
        error_string_alert = error_string_alert.replace(/&\s*$/, "");
        alert(error_string_alert);
        return false;
    } else {
        $('#PackageDiscountEditForm').submit();
    }
}
function update_counters(){
    //$('.discount_legend').each(function(k1,v1){$(this).find('legend').html('Offer '+(k1+1));});
}
</script>