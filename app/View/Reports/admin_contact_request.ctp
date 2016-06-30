<?php
echo $this->Html->script(array('moment.min'), array('inline' => false));
?>
<style type="text/css">
    div.tooltip-inner {max-width: 450px;}
    .box{min-height: 450px;}
</style>
<section id="ajax_div">
    <section class="content-header">
        <h1><?php echo __('Contact Us Requests'); ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'contact_request', 'admin' => 1)); ?>">Contact Us Requests</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo __('All Contact Us Requests'); ?></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="contacts_ad" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width:12%;"><?php echo __('ID'); ?></th>
                                    <th style="width:12%;"><?php echo __('User'); ?></th>
                                    <th style="width:11%;"><?php echo __('Email'); ?></th>
                                <?php /* <th style="width:20%;"><?php echo __('Subject'); ?></th> */?>
                                    <th style="width:37%;"><?php echo __('Message'); ?></th>
                                    <th style="width:14%;"><?php echo __('Created'); ?></th>
                                    <th style="width:6%;"><?php echo __('Action'); ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</section>
<script type="text/javascript">
    $(document).ready(function () {
        table = $('#contacts_ad').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "language": {
                "processing": "<img src='<?php echo HTTP_ROOT; ?>images/ajax-loader-v2.gif'>"
            },
            "info": true,
            "autoWidth": true,
            "aaSorting": [0, 'desc'], //[3, 'desc']
            "aoColumnDefs": [
            { "bVisible": false,  "aTargets": [0] },
                {
                    "aTargets": [1],
                    "mRender": function (data, type, row) {
                         if (row[1].length > 13)
                            return '<span title="" rel="tooltip" data-placement="top" data-original-title="' + row[1] + '">' + row[1].substring(0, 13) + '...' + '</span>';
                        else
                            return row[1];
                    }
                },
                {
                    "aTargets": [2],
                    "mRender": function (data, type, row) {
                         if (row[2].length > 15)
                            return '<span title="" rel="tooltip" data-placement="top" data-original-title="' + row[2] + '">' + row[2].substring(0, 15) + '...' + '</span>';
                        else
                            return row[2];
                    }
                },
                {
                    "aTargets": [3],
                    "mRender": function (data, type, row) {
                         if (row[3].length > 30)
                            return '<span title="" rel="tooltip" data-placement="top" data-original-title="' + row[3] + '">' + row[3].substring(0, 30) + '...' + '</span>';
                        else
                            return row[3];
                    }
                },
                {
                    "aTargets": [4],
                    "mRender": function (data, type, row) {
                         return moment(row[4]).format("MMM DD, YYYY");
                    }
                },
                {
                    "sClass": "text-center",
                    'bSortable': false,
                    "aTargets": [5],
                    "mData": null,
                    "mRender": function (data, type, row) {
                        var formatted_html = "";
                        var is_complete = (parseInt(row[5]) == 1) ? 'restore' : 'markcomplete';
                        var title = (is_complete == 'restore') ? "Restore" : "Mark Complete";
                        formatted_html += '<span class="action_links"><a data-id="' + row[0] + '" data-state="' + is_complete + '" data-mode="contactus" id="mark_complete_conreq_' + row[0] + '" rel="tooltip" data-original-title="' + title + '" class="mark_complete_conreq anchor">';
                        formatted_html += (parseInt(row[5]) == 1) ? '<span class="ion ion-refresh"></span>' : '<span class="ion ion-checkmark"></span>';
                        formatted_html += '</a></span>';
                        formatted_html += '<span class="action_links" style="margin-left: 10px;">';
                        formatted_html += '<a data-id="' + row[0] + '" data-username="' + row[1] + '" id="delete_contact_' + row[0] + '" rel="tooltip" data-original-title="Delete Contact" class="del_conreq anchor">';
                        formatted_html += '<span class="fa fa-trash-o"></span></a></span>';
                        return formatted_html;
                    }
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": HTTP_ROOT + "reports/contact_req_listings_ajax",
            "createdRow": function (row, data, index) {
                if (parseInt(data[5]) == 1) {
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

        $("#contacts_ad").on('click', '.del_conreq', function () {
            var id = $(this).data('id')
            if (confirm("Are You Sure want to delete the request from " + $(this).data('username') + " ?")) {
                $.ajax({
                    type: "POST",
                    data: {id: id},
                    url: "<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'delete_contact', 'admin' => 1)); ?>",
                    success: function (response) {
                        if (response) {
                            //$('#ajax_div').html(response);
                            table.ajax.reload(null, false);
                        }
                    }
                });
            }
        });
    });
    var page_name = "request";
    var act_url = "<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'mark_complete')); ?>";
</script>
