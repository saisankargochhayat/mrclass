<style>
    .action_links{margin:0 0 0 5px;}
    #subscription_details{border:1px solid #ddd;border-bottom:none}
    #subscription_details{margin-bottom: 15px;}
    #subscription_details tr td{text-align:left;padding:8px;border-bottom:1px solid #ddd}
</style>
<div class="booking_det">
    <div class="wrapper">
        <div class="content-left fl">
            <?php echo $this->element('user_inner_left_navbar'); ?>
        </div>
        <div class="fr upcom_book_cnt">
            <div class="bg-trns-white">
                <div class="up_mc_top1">
                    <h2>Subscription Details</h2>
                    <div class="cb"></div>
                </div>
                <table id="subscription_details" cellspacing="0" width="100%">
                    <tbody>
                            <tr>
                                    <td><?php echo __('Package Name'); ?></td>
                                    <td><?php echo $subscription_data['Subscription']['name'];?></td>
                            </tr>
                            <tr>
                                    <td><?php echo __('Listing Period'); ?></td>
                                    <td><?php echo $subscription_data['Subscription']['listing_period']." days";?></td>
                            </tr>
                            <tr>
                                    <td><?php echo __('Payment Method'); ?></td>
                                    <td><?php echo $subscription_data['Subscription']['payment_method'];?></td>
                            </tr>
                            <tr>
                                    <td><?php echo __('Subscription Start'); ?></td>
                                    <td><?php echo (!empty($subscription_data['Subscription']['subscription_start'])) ? $this->Format->dateFormat($subscription_data['Subscription']['subscription_start']) : "NA";?></td>
                            </tr>
                            <tr>
                                    <td><?php echo __('Subscription End'); ?></td>
                                    <td><?php echo (!empty($subscription_data['Subscription']['subscription_end'])) ? $this->Format->dateFormat($subscription_data['Subscription']['subscription_end']) : "NA";?></td>
                            </tr>
                            <?php if($subscription_data['Subscription']['status'] == '0'){
                                    $status = 'Inactive';
                            }else if($subscription_data['Subscription']['status'] == '2'){
                                    $status = 'Cancelled';
                            }else if($this->Format->is_subscription_expired($subscription_data['Subscription']['subscription_start'],$subscription_data['Subscription']['listing_period'])){
                                    $status = 'Expired';
                            }else{
                                    $status = 'Active';
                            }?>
                            <tr>
                                    <td><?php echo __('Status'); ?></td>
                                    <td><?php echo $status; ?></td>
                            </tr>
                            <tr>
                                    <td><?php echo __('Created'); ?></td>
                                    <td><?php echo $this->Format->dateFormat($subscription_data['Subscription']['created']);?></td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="cb"></div>
    </div>
</div>
