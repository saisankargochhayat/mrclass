<style>
    .dl-horizontal {padding: 5px 15px;}
    .dl-horizontal dt {text-align: left;}
    .dl-horizontal dt, .dl-horizontal dd {padding: 3px }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Looking for a Tutor Details</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link) ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('action' => 'index')) ?>">Looking for a Tutor</a></li>
        <li class="active">Details</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Looking for a Tutor Details</h3>
        </div>
        <div class="box-body">
            <dl class="dl-horizontal">
                <dt><?php echo __('Name'); ?></dt>
                <dd><?php echo h($inquiry['Inquiry']['name']); ?>&nbsp;</dd>
                <dt><?php echo __('Phone'); ?></dt>
                <dd><?php echo h($inquiry['Inquiry']['phone']); ?>&nbsp;</dd>
                <dt><?php echo __('Email'); ?></dt>
                <dd><a href="mail:<?php echo h($inquiry['Inquiry']['email']); ?>"><?php echo h($inquiry['Inquiry']['email']); ?>&nbsp;</a></dd>
                <dt><?php echo __('Type'); ?></dt>
                <dd><?php echo h(ucfirst($inquiry['Inquiry']['type'])); ?>&nbsp;</dd>
                <dt><?php echo __('Location'); ?></dt>
                <dd><?php echo h(ucfirst($inquiry['Inquiry']['location'])); ?>&nbsp;</dd>
                <dt><?php echo __('Min Age'); ?></dt>
                <dd><?php echo h($inquiry['Inquiry']['min_age']); ?> yr(s)&nbsp;</dd>
                <dt><?php echo __('Max Age'); ?></dt>
                <dd><?php echo h($inquiry['Inquiry']['max_age']); ?> yr(s)&nbsp;</dd>
                <dt><?php echo __('Category'); ?></dt>
                <dd>
                    <?php echo h($inquiry['Category']['name']); ?>
                    <?php #echo $this->Html->link($inquiry['Category']['name'], array('controller' => 'categories', 'action' => 'view', $inquiry['Category']['id'])); ?>
                    &nbsp;
                </dd>
                <?php /*<dt><?php echo __('Sub Category'); ?></dt>
                <dd>
                    <?php echo h($inquiry['SubCategory']['name']); ?>
                    <?php #echo $this->Html->link($inquiry['SubCategory']['name'], array('controller' => 'categories', 'action' => 'view', $inquiry['SubCategory']['id'])); ?>
                    &nbsp;
                </dd> */?>
                <dt><?php echo __('Comment'); ?></dt>
                <dd><?php echo h($inquiry['Inquiry']['comment']); ?>&nbsp;</dd>
                <dt><?php echo __('City'); ?></dt>
                <dd><?php echo h($inquiry['Inquiry']['city']); ?>&nbsp;
                </dd>
                <dt><?php echo __('Area'); ?></dt>
                <dd><?php echo h($inquiry['Inquiry']['area']); ?>&nbsp;
                </dd>
                <dt><?php echo __('Sent on'); ?></dt>
                <dd><?php echo $this->Format->dateTimeFormat($inquiry['Inquiry']['created']); ?>&nbsp;</dd>
                
            </dl>
        </div><!-- /.box-body -->
        <div class="box-footer">

        </div><!-- /.box-footer-->
    </div><!-- /.box -->

</section><!-- /.content -->