<?php
echo $this->Html->script(array('moment.min'), array('inline' => false));
?>
<style type="text/css">
    .box{
        min-height: 450px;
    }
</style>
<section class="content-header">
    <h1><?php echo __('Group Booking Requests'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'group_booking_requests', 'admin' => 1)); ?>">Group Bookings</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('All Group Booking Requests'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="group_bookings"class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('Name'); ?></th>
                                <th><?php echo __('Email'); ?></th>
                                <th><?php echo __('Phone'); ?></th>
                                <th><?php echo __('Group Size'); ?></th>
                                <th><?php echo __('Looking For'); ?></th>
                                <th><?php echo __('Address'); ?></th>
                                <th><?php echo __('Created'); ?></th>
                                <th style="text-align: center;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
    var view_booking_url = '<?php echo $this->Html->url(array("controller" => "reports","action" => "group_booking_requests","admin" => 1));?>';
    $(document).ready(function () {
       table = $('#group_bookings').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "language": {
                "processing": "<img src='<?php echo HTTP_ROOT; ?>images/ajax-loader-v2.gif'>"
            },
            "autoWidth": true,
            "aaSorting": [0, 'desc'],//[0, 'desc']
            "aoColumnDefs": [
                { "bVisible": false,'bSearchable': false,  "aTargets": [0] },
                {
                    "aTargets": [1],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                        if(row[1]){
                            return (row[1].length > 12) ? tooltip(row[1], 12,'admin') : row[1];
                        }else{
                            return "";
                        }
                    }
                },
                {
                    "aTargets": [2],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                        if(row[2]){
                            return (row[2].length > 12) ? tooltip(row[2], 12,'admin') : row[2];
                        }else{
                            return "";
                        }
                    }
                },
                {
                    "aTargets": [3],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                        if(row[3]){
                            var formatted_number = format_phone_number(row[3]);
                            return (formatted_number.length > 19) ? tooltip(formatted_number, 19,'admin') : formatted_number;
                        }else{
                            return "";
                        }
                    }
                },
                {
                    "aTargets": [5],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                        if (row[5].length > 30)
                            return tooltip(row[5], 30,'admin');
                        else
                            return row[5];
                    }
                },
                {
                    "aTargets": [6],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                        if (row[6].length > 20)
                            return tooltip(row[6], 20,'admin');
                        else
                            return row[6];
                    }
                },
                {
                    "aTargets": [7],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                       if(row[7]){
                            var created_valid = moment(row[7]).isValid();
                            var formatted_created = (created_valid) ? moment(row[7]).format("MMM DD, YYYY") : "";
                            return (formatted_created.length > 15) ? tooltip(formatted_created, 15,'admin') : formatted_created;
                        }else{
                            return "";
                        }
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
                        formatted_html += '<span class="action_links"><a data-id="' + row[0] + '" data-state="' + is_complete + '" data-mode="group_bookings" id="mark_complete_conreq_' + row[0] + '" rel="tooltip" data-original-title="' + title + '" class="mark_complete_conreq anchor">';
                        formatted_html += (parseInt(row[8]) == 1) ? '<span class="ion ion-refresh"></span>' : '<span class="ion ion-checkmark"></span>';
                        formatted_html += '</a></span>';
                        return formatted_html;
                    }
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": view_booking_url,
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
    });
    page_name = "booking";
    act_url = "<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'mark_complete')); ?>";
</script>
