<section class="content-header">
    <h1>Manage Localities</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#"><?php echo __('Localities'); ?></a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('All Localities'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo $this->Html->url(array('controller' => 'localities', 'action' => 'add', 'admin' => 1)); ?>" class="btn btn-block btn-primary btn-sm" data-target="#localityAddModal" data-toggle="modal"><i class="fa fa-plus"></i>  <?php echo __('Add Locality'); ?></a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="locality_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo __('Sl. No'); ?></th>
                                <th><?php echo __('City'); ?></th>
                                <th><?php echo __('Locality'); ?></th>
                                <th><?php echo __('Status'); ?></th>
                                <th style="text-align:center;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                      <?php $cnt = 0;
                      //pr($localities);exit;
                            foreach ($localities as $locality): ?>
                            <tr>
                                <td><?php echo h($cnt+1); ?>&nbsp;</td>
                                <td><?php echo h($locality['City']['name']); ?>&nbsp;</td>
                                <td><?php echo h($locality['Locality']['name']); ?>&nbsp;</td>
                                <td><?php echo h($locality['Locality']['status'] == '1' ? "Active" : "Inactive"); ?>&nbsp;</td>
                                <td style="text-align:center;">
                                    <!-- <span class="action_links">
                                                <?php //echo $this->Html->link('<i class="fa fa-eye"></i> ', array('action' => 'view',$locality['Locality']['id']),array('escape' => false,'class' => 'tip-top','data-toggle'=>'tooltip','data-original-title'=>'View','data-toggle'=>'modal','data-target'=>'#myModal')); ?>
                                    </span> -->
                                    <span class="action_links">
                                                <?php echo $this->Html->link('<i class="fa fa-pencil"></i> ', array('action' => 'edit',$locality['Locality']['id']),array('escape' => false,'class' => 'tip-top','rel'=>'tooltip','data-original-title'=>'Edit','data-toggle'=>'modal','data-target'=>'#localityAddModal')); ?>
                                    </span>
                                    <span class="action_links">
                                        <?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'fa fa-trash-o fa-fw')) . "",array('action' => 'admin_delete',$locality['Locality']['id']),array( 'escape' => false,'class' => 'tip-top','rel'=>'tooltip','data-original-title'=>'Delete','confirm' => __('Are you sure you want to delete # %s?', $locality['Locality']['name'])));?>
                                    </span>
                                </td>
                            </tr>
                      <?php $cnt++;
                            endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?php echo __('Sl. No'); ?></th>
                                <th><?php echo __('City'); ?></th>
                                <th><?php echo __('Locality'); ?></th>
                                <th><?php echo __('Status'); ?></th>
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
<script>
    $(document).ready(function () {
        var table = $('#locality_table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aaSorting": [[1, 'asc']],
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [4]},
            ]
        });

        table.on('draw', function () {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });

        $('#localityAddModal').on('hidden.bs.modal', function () {
            $(this).data('bs.modal', null);
        });
    });
    function setVal(sel) {
        var value = sel.value;
        $('#selectedcityID').val(value);
    }
</script>

