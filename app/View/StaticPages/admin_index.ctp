<style type="text/css">
    .actions {text-align: center; color: #666;}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo __('Static Pages'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#"><?php echo __('Static pages'); ?></a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('Static Pages'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo $this->Html->url(array( 'action' => 'add', 'admin' => 1)); ?>" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus"></i>  <?php echo __('New Static Page'); ?></a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">

                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo __('Title'); ?></th>
                                <th><?php echo __('URL'); ?></th>
                                <th class="actions"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($staticPages as $staticPage): ?>
                                <?php ($staticPage['StaticPage']['id']); ?>
                            <tr>
                                <td><?php echo h($staticPage['StaticPage']['title']); ?>&nbsp;</td>
                                <td><?php echo h($staticPage['StaticPage']['url']); ?>&nbsp;</td>
                                <td class="actions">
                                        <?php #echo $this->Html->link(__('View'), array('action' => 'view', $staticPage['StaticPage']['id']),array('class'=>'fa fa-eye')); ?>
                                        <?php echo $this->Html->link('', array('action' => 'edit', $staticPage['StaticPage']['id']),array('class'=>'fa fa-pencil fa-fw','rel'=>'tooltip','data-original-title'=>'Edit '.$staticPage['StaticPage']['title'])); ?>
                                        <?php #echo $this->Form->postLink('', array('action' => 'delete', $staticPage['StaticPage']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $staticPage['StaticPage']['id']),'class' => 'glyphicon glyphicon-remove-sign')); ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?php echo __('Title'); ?></th>
                                <th><?php echo __('URL'); ?></th>
                                <th class="actions"><?php echo __('Actions'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
