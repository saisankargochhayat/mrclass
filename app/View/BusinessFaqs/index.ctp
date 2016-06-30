<style type="text/css">
.inactiveLink{cursor: not-allowed;}
.inactiveLink:hover{border: 2px solid #FFE2A6;box-shadow: 0px 1px 2px #666;background: #FFE2A6;color: #fff;}
</style>
<?php 
$limit = (isset($subscription['Subscription']['faq'])) ? intval($subscription['Subscription']['faq']) : 0;
$existing_count = intval(count($businessFaqs));
if((isset($subscription['Subscription']['faq']) && empty($subscription['Subscription']['faq']))){
	$element_attrs = "class='cmn_btn_n inactiveLink' href='javascript:void(0)' title='You can not add business faqs. Please upgrade your subscription package'";
}else if(isset($subscription['Subscription']['faq']) && !empty($subscription['Subscription']['faq']) && ($limit == $existing_count)){
	$element_attrs = "class='cmn_btn_n inactiveLink' href='javascript:void(0)' title='Maximum business faq add limit reached. Please upgrade your subscription package'";
}else{
	$element_attrs = "class='cmn_btn_n' href='".$this->Html->url(array('action' => 'add',$BusinessId))."'";
}
?>
<div class="content-full business-timing-details">
    <div class="content-left fl">
        <?php echo $this->element('user_inner_left_navbar'); ?>
    </div>
    <div class="content-right fl">
        <div class="heading">
            <span class="edit-business"></span> Add/Update Business Faqs
				<div class="fr"><a <?php echo $element_attrs;?>>Add new faq</a></div>
			<div class="cb"></div>
        </div>
        <?php echo $this->element('front_edit_business_tabs', array('BusinessId' => $BusinessId)); ?>
        <div class="cb"></div>
        <div class="bg-trns-white">
			<div class="up_mc_top1">
                    <h2>Business Faqs</h2>
                    <div class="cb"></div>
                </div>
                <table id="business_faqs" class="display listblocks-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:15%;"><?php echo __('Title'); ?></th>
                            <th style="width:5%;text-align: center;"><?php echo __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($businessFaqs as $businessFaq) { ?>
                            <tr>
                                <td>
                                    <?php echo $businessFaq['BusinessFaq']['title']; ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php $BusinessFaqId = $businessFaq['BusinessFaq']['id']; ?>
                                        <span class="action_links">
											<a class="anchor" href="<?php echo $this->Html->url(array('action' => 'edit', $BusinessFaqId,$BusinessId)); ?>">
												<i class="fa fa-pencil"  title="Edit Faq"></i>
											</a>
                                        </span>
                                    <span class="action_links" style="margin-left:10px;">
                                        <a class="anchor" href="<?php echo $this->Html->url(array('action' => 'delete', $BusinessFaqId,$BusinessId)); ?>">
                                            <i class="fa fa-trash" title="Delete Faq"></i>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
        </div>
		
    </div>
    <div class="cb20"></div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#business_faqs').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aaSorting": [], //[0, 'desc']
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [1]},
            ]
        });
        table.on('draw', function() {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
    });
</script>