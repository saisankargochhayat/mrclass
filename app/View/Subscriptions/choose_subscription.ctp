<?php
$header_text = (trim($type) == "new") ? "Choose Subscription Package" : "Change Subscription Package";
$form_id = (trim($type) == "new" && intval($active_business_count) == 0) ? "subscriptionchooseform" : "subscriptionchangeform";
$form_method = (trim($type) == "new" && intval($active_business_count) == 0) ? "get" : "post";
$form_action = (trim($type) == "new" && intval($active_business_count) == 0) ? $this->Html->url(array("controller" => "businesses", "action" => "add")) : $this->Html->url(array("controller" => "subscriptions", "action" => "change_subscription"));
?>
<style type="text/css">
    .grey-box{
        width:100%;background:#EFEEEE; padding:30px; border:1px solid #aaa; font-size:16px; color:#333;margin: 30px 0;
        background: -webkit-linear-gradient(left,  #eee, #fff, #eee);
        background: -o-linear-gradient(left,  #eee, #fff, #eee);
        background: -moz-linear-gradient(left,  #eee, #fff, #eee);
        background: linear-gradient(to right, #eee, #fff, #eee);
    }
    .each-row{padding:15px 0; border-bottom: 1px solid #ccc;margin-bottom:20px;}
    .check-btn{width:50px;}
    .check-btn input[type='radio'] {
        transform: scale(1.5);
        -webkit-transform: scale(1.5);
        -moz-transform: scale(1.5);
    }
    .each-row .month_name{width:25%;}
    .each-row .amount{width:25%;}
    .each-row .sale-on{width:32%;}
    .amount{color:#F46E01;}
    .p-amount{text-decoration:line-through; font-size:16px;}
    .sale-on{color:#F46E01;font-size:16px;}
    .pro-chart{padding-bottom: 25px;}
</style>
<div class="booking_det">
    <div class="wrapper">
        <div class="content-left fl">
            <?php echo $this->element('user_inner_left_navbar'); ?>
        </div>
        <div class="fr upcom_book_cnt">
            <div class="up_mc_top my_bus">
                <h2><?php echo $header_text;?></h2>
                <div class="fr"><?php echo $this->Html->link(__('User Dashboard'), array('controller' => 'users', 'action' => 'dashboard'), array('class' => 'cmn_btn_n')); ?></div>
                <div class="cb"></div>
            </div>           
            <div class="cnt_bx_upcom fl">
                <div class="cnt_bx_upcom fl">
                    <div class="fl my_buisn cnt_innr_bus" style="width: 100%;text-align: center;padding:0 30px;position: relative;">
                        <h3>Select A Package.</h3>
                        <form id="<?php echo $form_id; ?>" method="<?php echo $form_method; ?>" action='<?php echo $form_action; ?>'>
                            <input type="hidden" name="referer" value="<?php echo $referer;?>">
                            <?php if ($type == "new") { ?>
                                <div class="form-group pckge_list">
                                    <?php echo $this->Form->input('package_id', array('class' => 'form-control select_custom', 'options' => $packages, 'empty' => __('Select Package'), 'div' => false, 'label' => false)); ?>
                                </div>
                            <?php } else { ?>
                                <div class="form-group pckge_list">
                                    <?php echo $this->Format->create_selectbox("data[package_id]", $packages, '', 'class="form-control select_custom"', "Select Package",""); ?>
                                </div>
                            <?php } ?>
                            <div class="package_discounts_user"></div>
                        </form>
                        <div class="cb"></div>
                        <div class="form-group pckge_list inactiveLink btn_div" style="width:25%;display:none;">
                            <a title="Please select a package first to proceed" class="cmn_btn_n" id="package_proceed" onclick="javascript:void(0)">Continue</a>
                        </div>
                        <div class="us_bs_mc">
                            <h4>Service Providers Packages</h4>
                        </div>
                        <div class="pro-chart">
                            <?php
                            $counter = 0;
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
                            $header_color_array = array('#009746', '#BDCF17', '#89CCD0', '#FABD3E', '#F3953E');
                            $header_width_array = array('14%', '16%', '16%', '16%', '16%');
                            foreach ($package_data as $k => $v) {
                                $package_class = strtolower($this->Format->seo_url($v['Package']['name'])) . " common_class";
                                $line1 .= '<th class="' . $package_class . '" style="background:' . $header_color_array[$counter] . ';width:' . $header_width_array[$counter] . ';" id="package_header_' . $counter . '">' . $v['Package']['name'] . '</th>';
                                $line2 .= '<td class="' . $package_class . '"><i class="fa fa-inr"></i>&nbsp;&nbsp;' . $v['Package']['price'] . " p.m." . '</td>';
                                $line3 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['priority_search'], 'boolean') . '</td>';
                                $line4 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['personal_subdomain'], 'boolean') . '</td>';
                                $line5 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['social_media_widget'], 'boolean') . '</td>';
                                $line6 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['map_integration'], 'boolean') . '</td>';
                                $line7 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['photo_limit'], 'string') . '</td>';
                                $line8 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['video_limit'], 'string') . '</td>';
                                $line9 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['subscription'], 'string') . '</td>';
                                $line10 .= '<td class="' . $package_class . '">' . $v['Package']['listing_period'] . "  days" . '</td>';
                                $line11 .= '<td class="' . $package_class . '">' . $v['Package']['payment_method'] . '</td>';
                                $line12 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['enquiries']) . '</td>';
                                $line13 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['address_detail']) . '</td>';
                                $line14 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['call_request']) . '</td>';
                                $line15 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['review']) . '</td>';
                                $line16 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['faq']) . '</td>';
                                $counter++;
                            }
                            echo '<table cellpadding="0" cellspacing="0" class="pricing-table">     
                        <tr>
                            <th style="background:#E53424;width:22%;">Features</th>' . $line1 . '
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Price</td>	' . $line2 . '
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Priority Search</td>' . $line3 . '
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Personal sub-domain</td>' . $line4 . '
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Social Media Widget</td>' . $line5 . '
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Google Map integration</td>' . $line6 . '
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Photos Upload</td>' . $line7 . '
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Videos Upload</td>' . $line8 . '
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Subscriptions</td>' . $line9 . '
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Listing Period</td>' . $line10 . '
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Payment method</td>' . $line11 . '
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Enquiries submission</td>' . $line12 . '
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Address details</td>' . $line13 . '
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Request a Call</td>' . $line14 . '
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Reviews</td>' . $line15 . '
                        </tr>
                        <tr>
                            <td style="font-weight:bold">FAQs</td>' . $line16 . '
                        </tr>
                </table>
            '; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cb"></div>
        </div>
        <div class="cb"></div>
    </div>
</div>
<script type="text/javascript">
var user_id = "<?php echo $user['id'];?>";
var form_id = "<?php echo $form_id;?>";
var package_discounts_url = "<?php echo $this->Html->url(array('controller' => 'package_discounts', 'action' => 'show_user_dicsounts')) ?>";
var check_discount_level = "<?php echo $this->Html->url(array('controller' => 'subscriptions', 'action' => 'check_package_constraints')) ?>";
var check_user_sub_details = "<?php echo $this->Html->url(array('controller' => 'subscriptions', 'action' => 'check_user_subscription_details')) ?>";
var business_exist;
var user_package_id;
var allow;
var resp_message;
var selected_p_id;
var lst_subscription_details;
var selected_package_details;
var user_subscription_status;
$(document).ready(function() {
    check_user_details();
    $(".select_custom").select2({
        minimumResultsForSearch: -1
    }).on("change", function(e) {
        if ($(this).select2('val')) {
            $('#package_proceed').closest('.btn_div').addClass('inactiveLink');
            $('#package_proceed').removeAttr('onclick');
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
        }else{
            $(".pricing-table th").eq(0).css('width', '22%');
            $('.btn_div').hide();
            $('.common_class').show().css('width', '16%');
            $('.package_discounts_user').html('').hide();
        }
    });
});

function display_package_details(package_id){
    selected_p_id = package_id;
    General.hideAlert('now');
    if(package_id){
        $('.overlay_div').show();
        $.ajax({
            url: package_discounts_url,
            type: 'POST',
            dataType: 'html',
            data: {package_id: package_id}
        }).done(function(data) {
            if(data){
                check_valid_selection(package_id,data,$('.loader'),$('.package_discounts_user'),$('.btn_div'),$('#package_proceed'));
			}
        });
    }else{
        alert("Invalid package.","error");
        General.hideAlert();
    }
}

function submit_form(id){
    $('#package_proceed').text('Please Wait...');
    $('#package_proceed').closest('.btn_div').addClass('inactiveLink');
    $('#'+id).submit();
}

function check_valid_selection(package_id,html_data,loader,discount_div,btn_div,btn){
    General.hideAlert('now');
    $.ajax({
        url: check_discount_level,
        type: 'POST',
        dataType: 'json',
        data: {package_id: package_id}
    }).done(function(data){
        if(data){
            selected_package_details = data.selected_package_details;
            $('.overlay_div').hide();
            if((selected_p_id == user_package_id) && !allow) {
                reset_page_elements();
                alert("Sorry. You can not subscribe to the same package untill it is expired or cancelled.", "error");
                General.hideAlert();
                return false;
            }
            if(user_subscription_status === 4 || user_subscription_status === 2){
                if (typeof lst_subscription_details !== 'undefined') {
                    if ((parseInt(selected_package_details.price) === 0) && (parseInt(lst_subscription_details.price) === 0)) {
                        reset_page_elements();
                        alert("Sorry. You can not subscribe to free package again. Please choose another package.", "error");
                        General.hideAlert();
                        return false;
                    }
                }
            }
            if ((typeof data.status == "boolean") && (data.status)) {
                $(discount_div).html(html_data).show();
                $(discount_div).find('.each-row:last').css('border-bottom', '0px');
                $(btn_div).show();
                $(btn).attr('onclick','submit_form("'+form_id+'");');
                $('#package_proceed').closest('.btn_div').removeClass('inactiveLink');
            }else{
                $(btn_div).hide();
                $(discount_div).html('').hide();
                $(".pricing-table th").eq(0).css('width', '22%');
                $('.common_class').show().css('width', '16%');
                alert(data.message,"error");
                General.hideAlert();
            }
        }
    });
}

function check_user_details(){
    $('.overlay_div').show();
    $.ajax({
        url: check_user_sub_details,
        type: 'POST',
        dataType: 'json',
        data: {},
    })
    .done(function(user_data) {
        $('.overlay_div').hide();
        business_exist = (parseInt(user_data.active_business)) ? true : false;
        user_package_id = user_data.package_id;
        allow = user_data.allow;
        resp_message = user_data.Message;
            if (user_data.subscription_details) {
                lst_subscription_details = user_data.subscription_details;
            }
            user_subscription_status = user_data.status;
    });
}

function reset_page_elements() {
    $(btn_div).hide();
    $(discount_div).html('').hide();
    $(".pricing-table th").eq(0).css('width', '22%');
    $('.common_class').show().css('width', '16%');
}
</script>