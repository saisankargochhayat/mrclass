<?php
$faq_limit = (isset($subscription['Subscription']['faq']) && !empty($subscription['Subscription']['faq'])) ? $subscription['Subscription']['faq'] : 0;
$existing_faq_count = count($businessFaqs);
if((isset($subscription['Subscription']['faq']) && empty($subscription['Subscription']['faq']))){
	$element_attrs = "class='btn btn-flat btn-primary btn-sm pull-left inactiveLinkblue' href='javascript:void(0)' rel='tooltip' title='You can not add business faqs. Business owner needs to upgrade the subscription package'";
}else if(isset($subscription['Subscription']['faq']) && !empty($subscription['Subscription']['faq']) && ($faq_limit == $existing_faq_count)){
	$element_attrs = "class='btn btn-flat btn-primary btn-sm pull-left inactiveLinkblue' rel='tooltip' href='javascript:void(0)' title='Maximum business faq add limit reached. Business owner needs to upgrade the subscription package'";
}else{
	$element_attrs = "class='btn btn-flat btn-primary btn-sm pull-left' rel='tooltip' title='Add new faq' href='".$this->Html->url(array('controller' => 'BusinessFaqs', 'action' => 'add', 'admin' => 1,$business_id))."'";
}
?>
<style type="text/css">
    div.tooltip-inner {max-width: 450px;}
</style>
<section class="content-header">
    <h1><?php echo __('Edit Business'); ?>: <?php echo h($business);?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'index', 'admin' => 1)); ?>">Businesses</a></li>
        <li class="active"><?php echo __('Edit Business'); ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <?php echo $this->element('admin_business_edit_tabs'); ?>
                <div class="tab-content">
                    <div class="active tab-pane" id="faqs">
                        <div class="box">
                            <div class="box-header with-border">
                                <i class="fa fa-star"></i>
                                <h3 class="box-title"><?php echo __('View faqs'); ?></h3>
                                <div class="box-tools pull-right">
									<a <?php echo $element_attrs;?>><i class="ion ion-person-add"></i>  Add Faq</a>
                    		</div>
                            </div><!-- /.box-header -->
                            <div class="box-body ">
                                <table id="bfaqs" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:15%;"><?php echo __('Ttile'); ?></th>
                                            <th style="width:10%;text-align:center;"><?php echo __('Actions'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                      		<?php $cnt = 0;
                            foreach ($businessFaqs as $businessFaq): ?>
                                <tr>
                                    <td><?php echo $this->Format->shortLength($businessFaq['BusinessFaq']['title'], 80,$businessFaq['BusinessFaq']['title']); ?>&nbsp;</td>
                                    <td style="text-align:center;">
                                        <span class="action_links">
                                                <a data-original-title="Edit" rel="tooltip" href="<?php echo $this->Html->url(array('action' => 'edit', 'admin' => 1, $businessFaq['BusinessFaq']['id'],$business_id)); ?>"><i class="fa fa-pencil"></i> </a>
                                        </span>
                                        <span class="action_links">
                                                <?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'fa fa-trash-o fa-fw')) . "",array('action' => 'delete',$businessFaq['BusinessFaq']['id'],$business_id),array( 'escape' => false,'class' => 'tip-top','rel'=>'tooltip','data-original-title'=>'Delete','confirm' => __('Are you sure you want to delete # %s?', $businessFaq['BusinessFaq']['title'])));?>
                                        </span>
                                    </td>
                                </tr>
                      <?php $cnt++;
                            endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><?php echo __('Title'); ?></th>
                                    <th style="text-align:center;"><?php echo __('Actions'); ?></th>
                                </tr>
                            </tfoot>
                                </table>
                            </div>
                        </div>
                    </div><!-- /.tab-pane -->    
                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
    $(document).ready(function () {
        table = $('#bfaqs').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [1]},
            ]
        });
        table.on('draw', function () {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
    });
</script>
