<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Manage Cities</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#"><?php echo __('Cities'); ?></a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('All Cities'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo $this->Html->url(array('controller' => 'cities', 'action' => 'add', 'admin' => 1)); ?>" class="btn btn-block btn-primary btn-sm" data-target="#cityAddModal" data-toggle="modal"><i class="fa fa-plus"></i>  <?php echo __('Add City'); ?></a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="city_listing" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo __('Sl. No'); ?></th>
                                <th><?php echo __('Name'); ?></th>
                                <th><?php echo __('State'); ?></th>
                                <th><?php echo __('Status'); ?></th>
                                <th><?php echo __('Business'); ?></th>
                                <th style="text-align:center;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th><?php echo __('Sl. No'); ?></th>
                                <th><?php echo __('Name'); ?></th>
                                <th><?php echo __('State'); ?></th>
                                <th><?php echo __('Status'); ?></th>
                                <th><?php echo __('Business'); ?></th>
                                <th><?php echo __('Actions'); ?></th>
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
    $(document).ready(function () {
        table = $('#city_listing').DataTable({
            "paging": true,
            "lengthChange": true,
            "language": {
                "processing": "<img src='<?php echo HTTP_ROOT; ?>images/ajax-loader-v2.gif'>"
            },
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aaSorting": [[1, 'asc']],
            "aoColumnDefs": [
                {
                    "aTargets": [3],
                    "mRender": function (data, type, row) {
                        return (row[3] == '1' ? "Active" : "Inactive");
                    }
                },
                {
                    "aTargets": [4],
                    "mRender": function (data, type, row) {
                        return (row[4] == '1' ? "Yes" : "No");
                    }
                },
                {
                    "sClass": "text-center",
                    'bSortable': false,
                    "aTargets": [5],
                    "mData": null,
                    "mRender": function (data, type, row) {
                        var formatted_html = "";
                        formatted_html += '<span class="action_links"><a data-target="#cityAddModal" data-original-title="Edit" data-toggle="modal" rel="tooltip" href="/mrclass/mcsuper/cities/edit/' + row[0] + '"><i class="fa fa-pencil"></i></a></span>';
                        formatted_html += '<span class="action_links">';
                        formatted_html += '<a href="/mrclass/mcsuper/cities/delete/' + row[0] + '" rel="tooltip" data-original-title="Delete" onclick="return confirm(\'Are you sure?\');"><span class="fa fa-trash-o fa-fw"></span></a>';
                        return formatted_html;
                    }
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": HTTP_ROOT + "cities/city_listings"
        });
//        setInterval(function () {
//            table.ajax.reload(null, false);
//        }, 3000);
        table.on('draw', function () {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
        $('#cityAddModal').on('hidden.bs.modal', function () {
            $(this).data('bs.modal', null);
        });
    });
</script>