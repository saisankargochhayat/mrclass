<style type="text/css">
    .skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side{background: #fff;}
    .invoice{border:0px none;}
    .alright{text-align: right;}
</style>
<?php
if (!empty($transactions['Transaction']['discount'])) {
    if ($transactions['Transaction']['sub_total'] < $transactions['Transaction']['discount']) {
        $label_text = "Carry Forward Balance";
        $total_text = "Total Refund";
        $desc = "Carry forward balance is the balance remained after downgrading from a higher package to lower package.In this case you are liable for a refund after deducting the current subscription package price from the remained balance.";
    } else {
        $label_text = "Discount";
        $total_text = "Total Price";
        $desc = "Discount price is the price remained from the last subscription, if you want to switch to another package before the current subscription ends.";
    }
} else {
    $label_text = "Discount";
    $total_text = "Total Price";
    $desc = "Discount price is the price remained from the last subscription, if you want to switch to another package before the current subscription ends.";
}
$label_text = "Adjustments (if any)";
?>
<?php $invoice_number = $transactions['Transaction']['reference_number']; ?>
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <?php echo $this->Html->image('logo.png', array('alt' => 'Logo')); ?></i> 
                <small class="pull-right">Date: <?php echo date('d/m/Y'); ?></small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <?php $address_arr = explode(",", Configure::read('COMPANY.ADDRESS')); ?>
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
                <strong><?php echo Configure::read('COMPANY.NAME'); ?></strong><br>
                <?php echo $address_arr[0]; ?>, <?php echo $address_arr[1]; ?> ,<br>
                <?php echo $address_arr[2]; ?>, <?php echo $address_arr[3]; ?> ,<?php echo $address_arr[4]; ?><br>
                Phone: <?php echo Configure::read('COMPANY.CONTACT_US_MOBILE'); ?><br>
                Email: <?php echo Configure::read('COMPANY.ADMIN_EMAIL'); ?>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            To
            <address>
                <?php if (!empty($transactions['Transaction']['user_detail'])) { ?>
                    <?php $user = json_decode($transactions['Transaction']['user_detail'], true); ?>

                    <strong><?php echo!empty($user['business']['Business']['name']) ? h($user['business']['Business']['name']) : h($businesses['Business']['name']); ?></strong><br>
                    <?php echo $user['business']['Business']['address']; ?>, <?php echo $user['business']['Locality']['name']; ?><br>
                    <?php echo!empty($user['business']['Business']['landmark']) ? $user['business']['Business']['landmark'] . ", " : ""; ?><?php echo $user['business']['City']['name'] . ", "; ?>Odisha - <?php echo $user['business']['Business']['pincode']; ?><br>
                    Phone: <?php echo!empty($user['user']['phone']) ? $this->Format->formatPhoneNumber($user['user']['phone']) : $this->Format->formatPhoneNumber($user['business']['Business']['phone']); ?><br>
                    Email: <?php echo!empty($user['user']['email']) ? $user['user']['email'] : $user['business']['Business']['email']; ?>
                <?php } else { ?>
                    <strong>
                        <?php if (is_array($businesses) && count($businesses) > 0) { ?>
                            <?php echo h($businesses['Business']['name']); ?>
                        <?php } else { ?>
                            <?php echo h($transactions['User']['name']); ?>
                        <?php } ?>
                    </strong><br>
                    <?php if (is_array($businesses) && count($businesses) > 0) { ?>
                        <?php echo $businesses['Business']['address']; ?>, <?php echo $businesses['Locality']['name']; ?><br>
                        <?php echo!empty($businesses['Business']['landmark']) ? $businesses['Business']['landmark'] . ", " : ""; ?><?php echo $businesses['City']['name'] . ", "; ?>Odisha - <?php echo $businesses['Business']['pincode']; ?><br>
                        Phone: <?php echo!empty($transactions['User']['phone']) ? $this->Format->formatPhoneNumber($transactions['User']['phone']) : $this->Format->formatPhoneNumber($businesses['Business']['phone']); ?><br>
                        Email: <?php echo!empty($transactions['User']['email']) ? $transactions['User']['email'] : $businesses['Business']['email']; ?>
                    <?php } ?>
                <?php } ?>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Invoice #:</b> <?php echo $transactions['Transaction']['invoice_number']; ?></b><br/>
            <b>Ref No:</b> <?php echo $transactions['Transaction']['reference_number']; ?><br/>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <?php
    $subscription_price = ($transactions['Subscription']['price']);
    $subtotal = $subscription_price * $transactions['price_array']['duration'];
    $discount = $subtotal - $transactions['price_array']['total_discountd_price'];
    ?>
    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Package</th>
                        <th>Subscription Start</th>
                        <th>Subscription End</th>
                        <th>Duration</th>
                        <th class="alright">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo h($transactions['Subscription']['name']); ?></td>
                        <td><?php echo $this->Format->dateFormat($transactions['Subscription']['subscription_start']); ?></td>
                        <td><?php echo $this->Format->dateFormat($transactions['Subscription']['subscription_end']); ?></td>
                        <td><?php echo $this->Format->showSubscriptionDetails($transactions['Subscription']['offer']); ?></td>
                        <td class="alright"><?php echo $this->Format->price($subtotal, ''); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
            <?php /* ?><p class="lead">Note:</p>
              <?php echo $this->Html->image('visa.png', array('alt' => 'Visa'));?>
              <?php echo $this->Html->image('mastercard.png', array('alt' => 'Mastercard'));?>
              <?php echo $this->Html->image('american-express.png', array('alt' => 'American Express'));?>
              <?php echo $this->Html->image('paypal2.png', array('alt' => 'Paypal'));?>
              <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;"><?php echo $desc; ?></p><?php */ ?>

        </div>
        <!-- /.col -->
        <div class="col-xs-6">
            <div class="table-responsive">
                <?php
                $price = number_format(intval($transactions['Package']['price']), 2);
                $tax = $this->Format->calc_percentage($price, 9.3, 2);
                $total = $price + $tax;
                ?>
                <table class="table">
                    <tr>
                        <th style="width:60%">Subtotal:</th>
                        <td class="alright"><?php echo $this->Format->price($subtotal, ''); ?></td>
                    </tr>
                    <?php if (floatval($discount) > 0) { ?>
                        <tr>
                            <th>Discount<?php echo $this->Format->checkDiscount($transactions['Subscription']['offer']); ?></th>
                            <td class="alright"><?php echo $this->Format->price($discount, ''); ?></td>
                        </tr>
                    <?php } ?>
                    <?php if (floatval($transactions['Transaction']['discount']) > 0) { ?>
                        <tr>
                            <th><?php echo $label_text; ?></th>
                            <td class="alright"><?php echo $this->Format->price($transactions['Transaction']['discount'], ''); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th><?php echo $total_text; ?></th>
                        <td class="alright"><?php echo $this->Format->price($transactions['Transaction']['final_price'], ''); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col -->

    </div>
    <!-- /.row -->
</section>
<footer>
    <div class="col-xs-12">
        <hr/>
        <p>Terms and Conditions</p>
        <p>*The charges are inclusive of all taxes including service tax.</p>
        <p>*Payment once received will not be refunded, however there is an option to upgrade the package in which case upgradation can be availed by paying the extra amount.</p>
        <p>*All price are in Indian Rupees(INR).</p>
        <p>*This is a system generated email, signature not required.</p>
        <p>*For payments made by cheque, demand draft, auto debit or credit card, this receipt and the transaction shall be valid subject to the realization of the instrument or transaction success..</p>
    </div>
</footer>
<?php if ($mode == 'print') { ?>
    <script type="text/javascript">
        window.print();
    </script>
<?php } ?>