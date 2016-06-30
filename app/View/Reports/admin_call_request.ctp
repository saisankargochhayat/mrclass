<?php
echo $this->Html->script(array('moment.min'), array('inline' => false));
?>
<style type="text/css">
    .box{
        min-height: 450px;
    }
</style>
<section id="ajax_div">
    <section class="content-header">
        <h1><?php echo __('Request a Call'); ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'call_request', 'admin' => 1)); ?>">Request a Call</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo __('All Request a Call'); ?></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="call_requests"class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo __('ID'); ?></th>
                                    <th><?php echo __('Business'); ?></th>
                                    <th><?php echo __('Category'); ?></th>
                                    <th><?php echo __('Address'); ?></th>
                                    <th><?php echo __('Name'); ?></th>
                                    <th><?php echo __('Phone'); ?></th>
                                    <th><?php echo __('Email'); ?></th>
                                    <th><?php echo __('Created'); ?></th>
                                    <th><?php echo __('Action'); ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
    <section>
    <?php #echo $this->element('modal'); ?>
<script type="text/javascript">
var categories;
    $(document).ready(function () {
        table = $('#call_requests').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "language": {
                "processing": "<img src='<?php echo HTTP_ROOT; ?>images/ajax-loader-v2.gif'>"
            },
            "autoWidth": true,
            "aaSorting": [0, 'desc'],//[3, 'desc']
            "aoColumnDefs": [
            { "bVisible": false,'bSearchable': false,  "aTargets": [0] },
                {
                    "aTargets": [1],
                    "mRender": function (data, type, row) {
                         if (row[1].length > 15)
                            return tooltip(row[1], 15,'admin');
                        else
                            return row[1];
                    }
                },
                {
                    "aTargets": [2],
                    'bSortable': false,
                    "mRender": function (data, type, row) {
                         if (row[2].length > 15)
                            return tooltip(row[2], 15,'admin');
                        else
                            return row[2];
                    }
                },
                {
                    "aTargets": [3],
                    "mRender": function (data, type, row) {
                         if (row[3].length > 25)
                            return tooltip(row[3], 25,'admin');
                        else
                            return row[3];
                    }
                },
                {
                    "aTargets": [4],
                    "mRender": function (data, type, row) {
                         if (row[4].length > 17)
                            return tooltip(row[4], 17,'admin');
                        else
                            return row[4];
                    }
                },
                {
                    "aTargets": [7],
                    "mRender": function (data, type, row) {
                         return moment(row[7]).format("MMM DD, YYYY");
                    }
                },
                {
                    "sClass": "text-center",
                    'bSortable': false,
                    'bSearchable': false,
                    "aTargets": [8],
                    "mData": null,
                    "mRender": function (data, type, row) {
                        var formatted_html = "";
                        var is_complete = (parseInt(row[8]) == 1) ? 'restore' : 'markcomplete';
                        var title = (is_complete == 'restore') ? "Restore" : "Mark Complete";
                        formatted_html += '<span class="action_links"><a data-id="' + row[0] + '" data-state="' + is_complete + '" data-mode="call_request" id="mark_complete_conreq_' + row[0] + '" rel="tooltip" data-original-title="' + title + '" class="mark_complete_conreq anchor">';
                        formatted_html += (parseInt(row[8]) == 1) ? '<span class="ion ion-refresh"></span>' : '<span class="ion ion-checkmark"></span>';
                        formatted_html += '</a></span>';
                        formatted_html += '<span class="action_links" style="margin-left: 10px;">';
                        formatted_html += '<a class="anchor call_del" data-id="' + row[0] + '" data-username="' + row[4] + '" id="delete_call_' + row[0] + '" rel="tooltip" data-original-title="Delete Request from '+row[4]+'">';
                        formatted_html += '<span class="fa fa-trash-o"></span></a></span>';
                        return formatted_html;
                    }
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": HTTP_ROOT + "reports/call_req_listings_ajax",
            },
            "createdRow": function (row, data, index) {
                if (parseInt(data[8]) == 1) {
                    $(row).addClass('restore');
                } else {
                    $(row).addClass('markcomplete');
                }
            }
        });
        table.on('draw', function () {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
        $("#call_requests").on('click','.call_del', function () {
            var id = $(this).data('id')
            if (confirm("Are You Sure want to delete the call request from " + $(this).data('username') + " ?")) {
                window.location.href = "<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'delete_call_request', 'admin' => 1)); ?>/"+id;
                return false;

                $.ajax({
                    type: "POST",
                    data: {id: id},
                    url: "<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'delete_call_request', 'admin' => 1)); ?>",
                    success: function (response) {
                        if (response) {
                            $('#ajax_div').html(response);
                        }
                    }
                });
            }

        });
    });
    page_name = "Call Request";
    act_url = "<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'mark_complete')); ?>";
</script>
