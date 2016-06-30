<style type="text/css">
    .date_fields{display: none;}
	.box.box-default {border-top-color: #fff;}
	.overlay{display:none;}
	.box .overlay>.fa, .overlay-wrapper .overlay>.fa{top:10%;font-size:55px;}
</style>
<?php
echo $this->Html->css(array('bootstrap-datepicker.min'), array('block' => 'bootstrap_datatable_css'));
echo $this->Html->script(array('bootstrap-datepicker.min','moment.min'), array('inline' => false));
?>
<section class="content-header">
    <h1><?php echo __('Add Subscriptions'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="<?php echo $this->Html->url(array('controller'=>'subscriptions','action'=>'index','admin'=>1));?>"><?php echo __('Subscriptions'); ?></a></li>
        <li><?php echo __('Add Subscription'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
               <li class="active"><a href="#subscriptionAdd" data-toggle="tab"><?php echo __('Add Subscription'); ?></a></li>
            </ul>
            <div class="box box-default">
               <!-- /.box-header -->
               <div class="box-body">
                  <div class="tab-content">
                     <?php echo $this->Form->create('Subscription',array('action'=>'add','class'=>'form-horizontal','autocomplete' => 'off')); ?>
                     <div class="active tab-pane" id="subscriptionAdd">
                        <div class="form-group">
                           <label for="SubscriptionUserId" class="col-sm-2 control-label"><?php echo __('Select User'); ?> *</label>
                           <div class="col-sm-10">
                              <?php #echo $this->Form->input('user_id', array('options'=>$users,'label' => false, 'div' => false,'empty'=>__('Select User'),'class' => 'form-control select2user')); ?>
                              <?php echo $this->Form->input('user_id', array('options'=>array(),'label' => false, 'div' => false,'empty'=>__('Select User'),'class' => 'form-control select2user')); ?>
                              <div class="error" id="SubscriptionUserIdErr"></div>
                              <div class="error" id="UserSubscriptionErr" style="display:none;"></div>
                           </div>
                        </div>
                        <div class="form-group">
                           <label for="SubscriptionPackageId" class="col-sm-2 control-label"><?php echo __('Select Package'); ?> *</label>
                           <div class="col-sm-10">
                              <?php echo $this->Form->input('package_id', array('options'=>array(),'label' => false, 'div' => false,'empty'=>__('Select Package'),'class' => 'form-control select2')); ?>
                              <div class="error" id="SubscriptionPackageIdErr"></div>
                           </div>
                        </div>
                        <div class="form-group date_fields">
                           <label for="SubscriptionSubscriptionStart" class="col-sm-2 control-label"><?php echo __('Subscription Start'); ?> <i title="" rel="tooltip" class="fa fa-info-circle" data-original-title="Enter the subscription start date. Subscription end date will be filled automatically based on the discount offer selected."></i></label>
                           <div class="col-sm-10">
                               <?php echo $this->Form->input('subscription_start', array('type' => 'text', 'label' => false, 'div' => false, 'readonly' => 'readonly', 'placeholder' => 'DD/MM/YYYY', 'class' => 'form-control date_picks')); ?>
                           </div>
                        </div>
                        <div class="form-group date_fields">
                           <label for="SubscriptionSubscriptionEnd" class="col-sm-2 control-label"><?php echo __('Subscription End'); ?></label>
                           <div class="col-sm-10">
                               <?php echo $this->Form->input('subscription_end', array('type' => 'text', 'label' => false, 'div' => false, 'readonly' => 'readonly', 'placeholder' => 'DD/MM/YYYY', 'class' => 'form-control date_picks')); ?>
                           </div>
                        </div>
                        <div class="form-group" id="button_proceed" style="display:none;">
                           <div class="col-sm-offset-2 col-sm-10">
                              <button type="button" class="btn btn-success" onclick="admin_add_subscription();"><?php echo __('Submit'); ?></button>
                           </div>
                        </div>
                     </div>
                     <!-- /.tab-pane -->
                     <div class="box box-warning package_discounts" style="display:none;">
                        <div class="box-header with-border">
                           <h3 class="box-title">Package Offers</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding package_discounts_user">
                           Select package to view all discounts.
                        </div>
                        <!-- /.box-body -->
                     </div>
                     <?php echo $this->Form->end(); ?>
                     <div class="box box-warning">
                        <div class="box-header with-border">
                           <h3 class="box-title">Package Pricing Table</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                           <?php $counter = 0;
                              $line1 = '';
                              $line2 = '';
                              $line3 = '';
                              $line4 = '';
                              $line5 = '';
                              $line6 = '';
                              $line7 = '';
                              $line8 = '';
                              $line9 = '';
                              $line10 = '';
                              $line11 = '';
                              $line12 = '';
                              $line13 = '';
                              $line14 = '';
                              $line15 = '';
                              $line16 = '';
                              $header_color_array = array('#009746','#BDCF17','#89CCD0','#FABD3E','#F3953E');
                              foreach($package_data as $k=>$v){
                                  $package_class = strtolower($this->Format->seo_url($v['Package']['name']))." common_class";
                                  $line1 .= '<th class="'.$package_class.'" style="background:'.$header_color_array[$counter].';" id="package_header_'.$counter.'">'.$v['Package']['name'].'</th>';
                                  $line2 .= '<td class="'.$package_class.'"><i class="fa fa-inr"></i>&nbsp;&nbsp;'.$v['Package']['price']." p.m.".'</td>';
                                  $line3 .= '<td class="'.$package_class.'">'.$this->Format->formatPackage($v['Package']['priority_search'],'boolean').'</td>';
                                  $line4 .= '<td class="'.$package_class.'">'.$this->Format->formatPackage($v['Package']['personal_subdomain'],'boolean').'</td>';
                                  $line5 .= '<td class="'.$package_class.'">'.$this->Format->formatPackage($v['Package']['social_media_widget'],'boolean').'</td>';
                                  $line6 .= '<td class="'.$package_class.'">'.$this->Format->formatPackage($v['Package']['map_integration'],'boolean').'</td>';
                                  $line7 .= '<td class="'.$package_class.'">'.$this->Format->formatPackage($v['Package']['photo_limit'],'string').'</td>';
                                  $line8 .= '<td class="'.$package_class.'">'.$this->Format->formatPackage($v['Package']['video_limit'],'string').'</td>';
                                  $line9 .= '<td class="'.$package_class.'">'.$this->Format->formatPackage($v['Package']['subscription'],'string').'</td>';
                                  $line10 .= '<td class="'.$package_class.'">'.$v['Package']['listing_period']."  days".'</td>';
                                  $line11 .= '<td class="'.$package_class.'">'.$v['Package']['payment_method'].'</td>';
                                  $line12 .= '<td class="'.$package_class.'">'.$this->Format->formatPackage($v['Package']['enquiries']).'</td>';
                                  $line13 .= '<td class="'.$package_class.'">'.$this->Format->formatPackage($v['Package']['address_detail']).'</td>';
                                  $line14 .= '<td class="'.$package_class.'">'.$this->Format->formatPackage($v['Package']['call_request']).'</td>';
                                  $line15 .= '<td class="'.$package_class.'">'.$this->Format->formatPackage($v['Package']['review']).'</td>';
                                  $line16 .= '<td class="'.$package_class.'">'.$this->Format->formatPackage($v['Package']['faq']).'</td>';
                              $counter++;
                              }
                              echo '<table cellpadding="0" cellspacing="0" class="table table-hover pricing-table">     
                                      <tr>
                                          <th style="background:#E53424;width:22%;">Features</th>'.$line1 .'
                                      </tr>
                                      <tr>
                                          <td style="font-weight:bold">Price</td> '.$line2 .'
                                      </tr>
                                      <tr>
                                          <td style="font-weight:bold">Priority Search</td>'.$line3 .'
                                      </tr>
                                      <tr>
                                          <td style="font-weight:bold">Personal sub-domain</td>'.$line4 .'
                                      </tr>
                                      <tr>
                                          <td style="font-weight:bold">Social Media Widget</td>'.$line5 .'
                                      </tr>
                                      <tr>
                                          <td style="font-weight:bold">Google Map integration</td>'.$line6 .'
                                      </tr>
                                      <tr>
                                          <td style="font-weight:bold">Photos Upload</td>'.$line7 .'
                                      </tr>
                                      <tr>
                                          <td style="font-weight:bold">Videos Upload</td>'.$line8 .'
                                      </tr>
                                      <tr>
                                          <td style="font-weight:bold">Subscriptions</td>'.$line9 .'
                                      </tr>
                                      <tr>
                                          <td style="font-weight:bold">Listing Period</td>'.$line10 .'
                                      </tr>
                                      <tr>
                                          <td style="font-weight:bold">Payment method</td>'.$line11 .'
                                      </tr>
                                      <tr>
                                          <td style="font-weight:bold">Enquiries submission</td>'.$line12 .'
                                      </tr>
                                      <tr>
                                          <td style="font-weight:bold">Address details</td>'.$line13 .'
                                      </tr>
                                      <tr>
                                          <td style="font-weight:bold">Request a Call</td>'.$line14 .'
                                      </tr>
                                      <tr>
                                          <td style="font-weight:bold">Reviews</td>'.$line15 .'
                                      </tr>
                                      <tr>
                                          <td style="font-weight:bold">FAQs</td>'.$line16 .'
                                      </tr>
                              </table>';?>
                        </div>
                        <!-- /.box-body -->
                     </div>
                  </div>
                  <!-- /.tab-content -->
               </div>
               <!-- /.box-body -->
			   <div class="overlay">
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
         </div>
         <!-- /.nav-tabs-custom -->
      </div>
      <!-- /.col -->
   </div>
   <!-- /.row -->
</section>
<!-- /.content -->
<script type="text/javascript">
var check_subscription_urls = '<?php echo $this->Html->url(array("controller" => "subscriptions","action" => "check_subscription_status","admin" => 1));?>';
var package_discounts_url = "<?php echo $this->Html->url(array('controller' => 'package_discounts', 'action' => 'show_user_dicsounts','admin'=>false)) ?>";
var admin_add_users_url = "<?php echo $this->Html->url(array('controller' => 'subscriptions', 'action' => 'add','admin'=>true)) ?>";
var business_exist;
var subscription_limits;
var user_business_count;
var int_package_id;
var user_package_id;
var allow;
var subscription_details;
$(document).ready(function() {
    $('#SubscriptionUserId').select2({
        placeholder: "Select User",
        minimumInputLength: 0,
        ajax: {
            url: admin_add_users_url,
            cache: true,
            delay: 300,
            dataType: 'json',
            //quietMillis: 100,
            data: function (term, page) {
                return {
                    term: term, //search term
                    //page_limit: 10 // page size
                };
            },
            results: function (data, page) {
                return { results: data.results };
            }
        }
    }).on("change", function(e) {
        check_active_subscriptions($(this).select2('val'));
    });
    $("#SubscriptionPackageId").select2({placeholder: "Select Package",minimumResultsForSearch: -1})
            .on("change", function(e) {
        if ($(this).select2('val')) {
            $(".pricing-table th").eq(0).css('width', '50%');
            $('.common_class').hide();
            switch (parseInt($(this).select2('val'))) {
                case 1:
                    $('.free').css('width', '50%').show();
                    break;
                case 2:
                    $('.silver').css('width', '50%').show();
                    break;
                case 3:
                    $('.gold').css('width', '50%').show();
                    break;
                case 4:
                    $('.platinum').css('width', '50%').show();
                    break;
                case 5:
                    $('.premium').css('width', '50%').show();
                    break;
                default:
                    $('.common_class').show();
                    break;
            }
            display_package_details($(this).select2('val'));
        }
    });
    $('.package_discounts_user').on('change', 'input[type=radio][name=discount]', function() {
        var start_date = $('.date_picks').eq(0).val();
        var checked_radio = $('.grey-box').find('input[type=radio]:checked');
        if($('.date_fields').is(':visible')){
          if (start_date) {
              update_date_fields(start_date, checked_radio);
          }
        }
    });
    $('.date_picks:eq(0)').on('change', function(e) {
        if ($(this).val()) {
            if (moment($(this).val(), 'DD/MM/YYYY', true).isValid()) {
                var checked_radio = $('.grey-box').find('input[type=radio]:checked');
                update_date_fields($(this).val(), checked_radio);
            }
        } else {
            $('.date_picks:eq(1)').val('');
        }
    });
});

function display_package_details(package_id) {
    if (package_id) {
        int_package_id = parseInt(package_id);
        $('.overlay').show();
        $.ajax({
                url: package_discounts_url,
                type: 'POST',
                dataType: 'html',
                data: {
                    package_id: package_id
                }
            })
            .done(function(data) {
                if (data) {
                    $('.overlay').hide();
                    if (user_business_count > subscription_limits[int_package_id]) {
                        reset_elements('new value');
                        //alert("Users business limit exceeds than the selected package. Please select a higher package.");
                        if(!confirm("Users business limit exceeds than the selected package. Are you sure to assign the package?")){
                            return false
                        }
                    } 
                    if ((package_id == user_package_id) && !allow) {
                        reset_elements('new value');
                        alert("User has already subscribed to this package.");
                        //alert("You can not subscribe to the same package unless it is expired or cancelled.");
                    } else {
                        $('.package_discounts').show();
                        $('.package_discounts_user').html(data);
                        $('.date_fields').show();
                        $('.date_picks').val('');
                        $('.date_picks').eq(1).val('');
                        $('.date_picks').eq(0).datepicker({format: "dd/mm/yyyy",clearBtn: true,autoclose: true,todayHighlight: true})
                                .on('changeDate', function(e) {moment(e.date).format('DD/MM/YYYY');var date = moment(e.date);var formatted_date = date.format('DD/MM/YYYY');var checked_radio = $('.grey-box').find('input[type=radio]:checked');update_date_fields(formatted_date, checked_radio);});
                        var x = new Date(subscription_details.subscription_end);
                        x.setDate(x.getDate()+1);
                        var m = x>new Date()?moment(x):moment();
                        //console.log(moment(x));
                        //console.log(m);
                        start_date_formatted = m.format('DD/MM/YYYY');
                        var radio = $('.grey-box').find('input[type=radio]:checked');
                        month_val = $(radio).attr('data-month');
                        months = parseInt(month_val) || 1;
                        sub_days = months * 30;
                        end_date = m.add(sub_days, 'days');
                        end_date_formatted = end_date.format('DD/MM/YYYY');
                        //console.log(start_date_formatted+" >> "+end_date_formatted);
                        if (business_exist) {
                            $('.date_fields').show();
                            $('.date_picks').eq(0).val(start_date_formatted);
                            $('.date_picks').eq(1).val(end_date_formatted);
                        } else if (!business_exist) {
                            $('.date_fields').hide();
                        }
                        $('.date_fields').show();
                        $('.date_picks').eq(0).val(start_date_formatted);
                        $('.date_picks').eq(1).val(end_date_formatted);
                        
                        $('#button_proceed').show();
                    }
                }
            });
    } else {
        alert("Invalid package.", "error");
    }
}

function update_date_fields(start_date, radio_obj) {
    var months, month_val, current_date, sub_days, end_date, end_date_formatted;
    if (start_date) {
        month_val = $(radio_obj).attr('data-month');
        months = parseInt(month_val) || 1;
        current_date = moment(start_date, 'DD/MM/YYYY');
        sub_days = months * 30;
        end_date = current_date.add(sub_days, 'days');
        end_date_formatted = end_date.format('DD/MM/YYYY');
        $('.date_picks').eq(1).val(end_date_formatted);
    }
}

function check_active_subscriptions(user_id) {
    var message_div = $('#UserSubscriptionErr');
    if (message_div.is(':visible')) {
        message_div.hide();
    }
    if (user_id) {
        message_div.css('color', 'black').show().html('Please wait....');
        $('.overlay').show();
        $.ajax({
            url: check_subscription_urls,
            type: 'POST',
            dataType: "json",
            data: {user_id: user_id},
            success: function(response) {
                var message_color;
                var formatted_html = '';
                if (response) {
                    switch (response.status) {
                        case 1:
                        case 5:
                            message_color = '#f39c12';
                            formatted_html += '<i class="ion ion-alert-circled"></i> ';
                            break;
                        case 2:
                        case 4:
                            message_color = '#dd4b39';
                            formatted_html += '<i class="ion ion-close-circled"></i> ';
                            break;
                        case 3:
                            message_color = '#00a65a';
                            formatted_html += '<i class="ion ion-checkmark-circled"></i> ';
                            break;
                        default:
                            message_color = '#00c0ef';
                            formatted_html += '<i class="fa fa-info-circle"></i> ';
                            break;
                    }
                    formatted_html += response.Message;
                    subscription_limits = response.package_limits;
                    user_business_count = response.active_business;
                    user_package_id = response.package_id;
                    subscription_details = response.subscription_details;
                    allow = response.allow;
                    message_div.html('');
                    message_div.css({fontSize: '17px',color: message_color}).show().html(formatted_html);
                    business_exist = (parseInt(response.active_business)) ? true : false;
                    set_fields(response.package_list);
                }
            }
        });
    } else {
        business_exist = false;
        reset_elements();
    }
}

function set_fields(res) {
    reset_elements();
    $("#SubscriptionPackageId").html('');
    $("#SubscriptionPackageId").select2({placeholder: "Select Package",minimumResultsForSearch: -1,data: res});
    $('.overlay').hide();
};

function reset_elements() {
    if (!arguments[0]) {
        $("#SubscriptionPackageId").html('').select2({placeholder: "Select Package",minimumResultsForSearch: -1});
    }
    $('.date_picks').val('');
    $('.date_picks').eq(0).removeAttr('readonly');
    $('.date_fields').hide();
    $('#button_proceed').hide();
    $('.package_discounts_user').html('');
    $('.package_discounts').hide();
    $(".pricing-table th").eq(0).css('width', '22%');
    $('.common_class').show().css('width', '16%');
}
</script>
