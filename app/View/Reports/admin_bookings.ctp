<?php
echo $this->Html->script(array('moment.min'), array('inline' => false));
?>
<style type="text/css">
    .box{
        min-height: 450px;
    }
</style>
<section class="content-header">
    <h1><?php echo __('Business Bookings'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'bookings', 'admin' => 1)); ?>">Business Bookings</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('All Business Bookings'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="bookings"class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('Created'); ?></th>
                                <th><?php echo __('User'); ?></th>
                                <th><?php echo __('Class'); ?></th>
                                <th><?php echo __('Category'); ?></th>
                                <th><?php echo __('Address'); ?></th>
                                <th><?php echo __('Booking From'); ?></th>
                                <th><?php echo __('Booking To'); ?></th>
                                <th><?php echo __('# Booked Seats'); ?></th>
                                <th><?php echo __('Code'); ?></th>
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
    var view_booking_url = '<?php echo $this->Html->url(array("controller" => "reports","action" => "view_booking","admin" => 1));?>';
    $(document).ready(function () {
       table = $('#bookings').DataTable({
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
                            var created_valid = moment(row[1]).isValid();
                            var formatted_created = (created_valid) ? moment(row[1]).format("MMM DD, YYYY") : "";
                            return (formatted_created.length > 10) ? tooltip(formatted_created, 10,'admin') : formatted_created;
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
                            return (row[2].length > 10) ? tooltip(row[2], 10,'admin') : row[2];
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
                            return (row[3].length > 8) ? tooltip(row[3], 8,'admin') : row[3];
                        }else{
                            return "";
                        }
                    }
                },
                {
                    "aTargets": [4],
                    'bSortable': false,
                    //'bSearchable': false,
                    "mRender": function(data, type, row) {
                        if (row[4].length > 12)
                            return tooltip(row[4], 12,'admin');
                        else
                            return row[4];
                    }
                },
                {
                    "aTargets": [5],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                        if (row[5].length > 10)
                            return tooltip(row[5], 10,'admin');
                        else
                            return row[5];
                    }
                },
                {
                    "aTargets": [6],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                       if(row[6]){
                            var created_valid = moment(row[6]).isValid();
                            var formatted_created = (created_valid) ? moment(row[6]).format("MMM DD, YYYY") : "";
                            return (formatted_created.length > 15) ? tooltip(formatted_created, 15,'admin') : formatted_created;
                        }else{
                            return "";
                        }
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
                    "aTargets": [10],
                    "mData": null,
                    "mRender": function (data, type, row) {
                        var formatted_html = "";
                        var is_complete = (parseInt(row[10]) == 1) ? 'restore' : 'markcomplete';
                        var title = (is_complete == 'restore') ? "Restore" : "Mark Complete";
                        formatted_html += '<span class="action_links"><a data-id="' + row[0] + '" data-state="' + is_complete + '" data-mode="business_bookings" id="mark_complete_conreq_' + row[0] + '" rel="tooltip" data-original-title="' + title + '" class="mark_complete_conreq anchor">';
                        formatted_html += (parseInt(row[10]) == 1) ? '<span class="ion ion-refresh"></span>' : '<span class="ion ion-checkmark"></span>';
                        formatted_html += '</a></span>';
                        formatted_html += '<span class="action_links" style="margin-left: 10px;">';
                        formatted_html += '<a href="' + view_booking_url + '/' + row[0] + '" rel="tooltip" data-original-title="View details about this booking"><i class="fa fa-eye"></i> </a>';
                        formatted_html += '</span>';
                        return formatted_html;
                    }
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": HTTP_ROOT + "reports/bookings_ajax",
            "createdRow": function (row, data, index) {
                if (parseInt(data[10]) == 1) {
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
