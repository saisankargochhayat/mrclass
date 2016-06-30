<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage Careers
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><a href="#"><?php echo __('Careers'); ?></a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo __('All Careers'); ?></h3>
                        <div class="box-tools pull-right">
                        <a href="<?php echo $this->Html->url(array('controller' => 'careers', 'action' => 'add', 'admin' => 1)); ?>" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus"></i>  <?php echo __('Add Career'); ?></a>
                    </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="careerTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo __('Title'); ?></th>
                                    <!--<th><?php // echo __('Description'); ?></th>-->
                                    <th style="text-align:center;"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                      <?php $cnt = 0;
                            foreach ($careers as $career): ?>
                                <tr>
                                    <td><?php echo h($career['Career']['title']); ?>&nbsp;</td>
                                    <!--<td><?php //echo h($career['Career']['content']); ?>&nbsp;</td>-->
                                    <td style="text-align:center;">
                                        <!-- <span class="action_links">
                                                <?php //echo $this->Html->link('<i class="fa fa-eye"></i> ', array('action' => 'view',$city['City']['id']),array('escape' => false,'class' => 'tip-top','data-toggle'=>'tooltip','data-original-title'=>'View','data-toggle'=>'modal','data-target'=>'#myModal')); ?>
                                        </span> -->
                                        <span class="action_links">
                                                <?php //echo $this->Html->link('<i class="fa fa-pencil-square-o"></i> ', array('action' => 'admin_edit',$city['City']['id']),array('escape' => false,'class' => 'tip-top','data-toggle'=>'tooltip','data-original-title'=>'Edit','data-toggle'=>'modal','data-target'=>'#cityAddModal')); ?>
                                                <a data-original-title="Edit" rel="tooltip" href="<?php echo $this->Html->url(array('controller' => 'careers', 'action' => 'edit', 'admin' => 1, $career['Career']['id'])); ?>"><i class="fa fa-pencil"></i> </a>
                                        </span>
                                        <span class="action_links">
                                                <?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'fa fa-trash-o fa-fw')) . "",array('action' => 'delete',$career['Career']['id']),array( 'escape' => false,'rel'=>'tooltip','data-original-title'=>'Delete','confirm' => __('Are you sure you want to delete # %s?', $career['Career']['title'])));?>
                                        </span>
                                    </td>
                                </tr>
                      <?php $cnt++;
                            endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><?php echo __('Title'); ?></th>
                                    <!--<th><?php // echo __('Description'); ?></th>-->
                                    <th style="text-align:center;"><?php echo __('Actions'); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
    <?php echo $this->element('modal'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        var table = $('#careerTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aaSorting": [[0,'asc']],
             "aoColumnDefs": [
              { 'bSortable': false, 'aTargets': [1] },
            ]
        });
        table.on('draw', function () {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());  
        });
        $('#careerAddModal').on('hidden.bs.modal', function() {
            $(this).data('bs.modal', null);
        });
    });
</script>

