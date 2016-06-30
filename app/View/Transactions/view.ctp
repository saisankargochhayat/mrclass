<?php 
if(!empty($transaction_data['Transaction']['discount'])){
    if($transaction_data['Transaction']['sub_total'] < $transaction_data['Transaction']['discount']){
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
    .action_links{margin:0 0 0 5px;}
    #transaction_details{border:1px solid #ddd;border-bottom:none}
    #transaction_details{margin-bottom: 15px;}
    #transaction_details tr td{text-align:left;padding:8px;border-bottom:1px solid #ddd}
    .price{color:black;}
</style>
<div class="booking_det">
    <div class="wrapper">
        <div class="content-left fl">
            <?php echo $this->element('user_inner_left_navbar'); ?>
        </div>
        <div class="fr upcom_book_cnt">
            <div class="bg-trns-white">
                <div class="up_mc_top1">
                    <h2>Transaction Details</h2>
                    <div class="cb"></div>
                </div>
                <table id="transaction_details" class="" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                    <td><?php echo __('Package Name'); ?></td>
                                    <td><?php echo $transaction_data['Subscription']['name'];?></td>
                            </tr>
                            <tr>
                                    <td><?php echo __('Sub-total Price'); ?></td>
                                    <td><?php echo "<i class='fa fa-inr price'></i>&nbsp;&nbsp;".$transaction_data['Transaction']['sub_total'];?></td>
                            </tr>
                            <tr>
                                    <td><?php echo $label_text; ?></td>
                                    <td><?php echo "<i class='fa fa-inr price'></i>&nbsp;&nbsp;".$transaction_data['Transaction']['discount'];?></td>
                            </tr>
                            <tr>
                                    <td><?php echo $total_text; ?></td>
                                    <td><?php echo "<i class='fa fa-inr price'></i>&nbsp;&nbsp;".$transaction_data['Transaction']['final_price'];?></td>
                            </tr>
                            <tr>
                                    <td><?php echo __('Payment Mode'); ?></td>
                                    <td><?php echo $transaction_data['Transaction']['mode'];?></td>
                            </tr>
                            <tr>
                                    <td><?php echo __('Reference Number'); ?></td>
                                    <td><?php echo $transaction_data['Transaction']['reference_number'];?></td>
                            </tr>
                            <tr>
                                    <td><?php echo __('Subscription Date'); ?></td>
                                    <td><?php echo $this->Format->dateFormat($transaction_data['Subscription']['created']);?></td>
                            </tr>
                            <tr>
                                    <td><?php echo __('Status'); ?></td>
                                    <td><?php echo $transaction_data['Transaction']['status']; ?></td>
                            </tr>
                        </tbody>
                </table>
            </div>
        </div>
        <div class="cb"></div>
    </div>
</div>
