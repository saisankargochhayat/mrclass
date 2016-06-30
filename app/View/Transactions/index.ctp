<style>
    .action_links{margin:0 0 0 5px;}
</style>
<div class="booking_det">
    <div class="wrapper">
        <div class="content-left fl">
            <?php echo $this->element('user_inner_left_navbar'); ?>
        </div>
        <div class="fr upcom_book_cnt">
            <div class="bg-trns-white">
                <div class="up_mc_top1">
                    <h2>Your Transactions</h2>
                    <div class="cb"></div>
                </div>
                <table id="transactions_user" class="display listblocks-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:15%;"><?php echo __('Name'); ?></th>
                            <th style="width:20%;"><?php echo __('Mode'); ?></th>
                            <th style="width:20%;"><?php echo __('Ref. No.'); ?></th>
                            <th style="width:15%;"><?php echo __('Status'); ?></th>
                            <th style="width:15%;"><?php echo __('Date'); ?></th>
                            <th style="width:5%;text-align: center;"><?php echo __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $transaction) { ?>
                            <tr>
                                <td><?php echo $transaction['Subscription']['name'];?></td>
                                <td>
                                    <?php echo $transaction['Transaction']['mode'];?>
                                </td>
                                <td>
                                    <?php echo $transaction['Transaction']['reference_number'];?>
                                </td>
                                <td>
                                    <?php echo $transaction['Transaction']['status'];?>
                                </td>
                                <td>
                                    <?php echo $this->Format->dateFormat($transaction['Transaction']['created']);?>
                                </td>
                                <td style="text-align: center;">
                                    <?php $transactionID = $transaction['Transaction']['id']; ?>
                                    <span class="action_links">
                                        <a class="anchor" title="View Transaction Details" href="<?php echo $this->Html->url(array('action' => 'view', $transactionID)); ?>">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </span>
                                    <?php if($transaction['Subscription']['status'] == "1"){?>
                                    <span class="action_links">
                                        <a class="anchor" title="Download Invoice" href="<?php echo $this->Html->url(array('action' => 'generate_pdf', $transactionID)); ?>">
                                           <i class="fa fa-download"></i>
                                        </a>
                                    </span>
                                    <?php }?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="cb"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#transactions_user').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aaSorting": [], 
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [5]},
            ]
        });
        table.on('draw', function() {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
    });
</script>