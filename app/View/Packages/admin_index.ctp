<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Manage Packages</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">
            <a href="#">
                <?php echo __('Packages'); ?>
            </a>
        </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('All Packages'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo $this->Html->url(array('controller' => 'packages', 'action' => 'add', 'admin' => 1)); ?>" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus"></i>  <?php echo __('Add Package'); ?></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="package_listing" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <?php echo __('Id'); ?>
                                </th>
                                <th>
                                    <?php echo __('Name'); ?>
                                </th>
                                <th>
                                    <?php echo __('Price'); ?>
                                </th>
                                <th>
                                    <?php echo __('Subscriptions'); ?>
                                </th>
                                <th>
                                    <?php echo __('Listing Period'); ?>
                                </th>
                                <th>
                                    <?php echo __('Payment Period'); ?>
                                </th>
                                <th>
                                    <?php echo __('Created'); ?>
                                </th>
                                <th style="text-align:center;">
                                    <?php echo __('Actions'); ?>
                                </th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>
                                    <?php echo __('Id'); ?>
                                </th>
                                <th>
                                    <?php echo __('Name'); ?>
                                </th>
                                <th>
                                    <?php echo __('Price'); ?>
                                </th>
                                <th>
                                    <?php echo __('Subscriptions'); ?>
                                </th>
                                <th>
                                    <?php echo __('Listing Period'); ?>
                                </th>
                                <th>
                                    <?php echo __('Payment Period'); ?>
                                </th>
                                <th>
                                    <?php echo __('Created'); ?>
                                </th>
                                <th style="text-align:center;">
                                    <?php echo __('Actions'); ?>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<script type="text/javascript">
    var view_package_url = '<?php echo $this->Html->url(array("controller" => "packages","action" => "view","admin" => 1));?>';
    var view_package_offer_url = '<?php echo $this->Html->url(array("controller" => "package_discounts","action" => "edit","admin" => 1));?>';
    var edit_package_url = '<?php echo $this->Html->url(array("controller" => "packages","action" => "edit","admin" => 1));?>';
    var delete_package_url = '<?php echo $this->Html->url(array("controller" => "packages","action" => "delete","admin" => 1));?>';
    $(document).ready(function () {
        page_no = getCookie(CONTROLLER+ACTION+'page_no');
        page_limit = getCookie(CONTROLLER+ACTION+'page_limit');
       table = $('#package_listing').DataTable({
            "paging": true,
            "lengthChange": true,
            "language": {
                "processing": "<img src='<?php echo HTTP_ROOT; ?>images/ajax-loader-v2.gif'>"
            },
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "pageLength": !isNaN(parseInt(page_limit))?(parseInt(page_limit)):10,
            "aaSorting": [0, 'asc'],
            "aoColumnDefs": [
                { "bVisible": false,  "aTargets": [0] },
                {
                    "aTargets": [2],
                    "mRender": function (data, type, data) {
                        return data[2]+" p.m.";
                    }
                },
                {
                    "aTargets": [3],
                    "mRender": function (data, type, data) {
                        return (parseInt(data[3])) == 1 ? '1' : "Up to "+data[3];
                    }
                },
                {
                    "aTargets": [4],
                    "mRender": function (data, type, data) {
                        return data[4]+" days";
                    }
                },
                {
                    "sClass": "text-center",
                    'bSortable': false,
                    "aTargets": [7],
                    "mData": null,
                    "mRender": function (data, type, row) {
                        var formatted_html = "";
                        formatted_html += '<span class="action_links"><a data-original-title="Edit" rel="tooltip" href="' + edit_package_url + '/' + row[0] + '"><i class="fa fa-pencil"></i></a></span>';
                        formatted_html += '<span class="action_links">';
                        formatted_html += '<a href="javascript:void(0)" rel="tooltip" data-package="'+row[1]+'" data-id="'+row[0]+'" class="delete_package" data-original-title="Delete"><span class="fa fa-trash-o fa-fw"></span></a></span>';
                        formatted_html += '<span class="action_links"><a href="' + view_package_url + '/' + row[0] + '" rel="tooltip" data-original-title="View details about this package" class=""><i class="fa fa-eye"></i> </a></span>';
                        formatted_html += '<span class="action_links"><a href="' + view_package_offer_url + '/' + row[0] + '" rel="tooltip" data-original-title="View all offers of this package" class=""><i class="fa fa-gift"></i> </a></span>';
                        return formatted_html;
                    }
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": HTTP_ROOT + "packages/packages_ajax"
        });
        table.on('draw', function () {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
        
        $("#package_listing").on('click', '.delete_package', function () {
            var id = $(this).data('id')
            if (confirm("Are You Sure want to delete the package " + $(this).data('package') + " ?")) {
                $.ajax({
                    type: "POST",
                    data: {id: id},
                    url: "<?php echo $this->Html->url(array('controller' => 'packages', 'action' => 'delete', 'admin' => 1)); ?>",
                    success: function (response) {
                        if (response) {
                            table.ajax.reload(null, false);
                        }else{
                            alert("The package could not be deleted. Please, try again.");
                        }
                    }
                });
            }
        });
    });
</script>