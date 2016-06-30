<?php
echo $this->Html->script(array('moment.min'), array('inline' => false));
?>
<section class="content-header">
    <h1>Manage Event Inquiry</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller' => 'events', 'action' => 'index', 'admin' => 1)); ?>">Events</a></li>
        <li class="active"><?php echo __('Event Inquiry'); ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('Event Inquiry'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo $this->Html->url(array('controller' => 'events', 'action' => 'add', 'admin' => 1)); ?>" class="btn btn-flat btn-primary btn-sm pull-left"><i class="fa fa-trophy"></i>  <?php echo 'Add Event'; ?></a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="eventList" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('Event'); ?></th>
                                <th><?php echo __('User'); ?></th>
                                <th><?php echo __('Phone'); ?></th>
                                <th><?php echo __('Email'); ?></th>
                                <th><?php echo __('Act'); ?></th>
                                <th><?php echo __('Ip'); ?></th>
                                <th><?php echo __('Created On'); ?></th>
                                <th style="text-align:center;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('Event'); ?></th>
                                <th><?php echo __('User'); ?></th>
                                <th><?php echo __('Phone'); ?></th>
                                <th><?php echo __('Email'); ?></th>
                                <th><?php echo __('Act'); ?></th>
                                <th><?php echo __('Ip'); ?></th>
                                <th><?php echo __('Created On'); ?></th>
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
    var grant_event_url = '<?php echo $this->Html->url(array("controller" => "events", "action" => "grant", "admin" => 1)); ?>';
    var edit_event_url = '<?php echo $this->Html->url(array("controller" => "events", "action" => "edit", "admin" => 1)); ?>';
    var delete_event_url = '<?php echo $this->Html->url(array("controller" => "events", "action" => "delete_inquiry", "admin" => 1)); ?>';
    var ajax_url = '<?php echo $this->Html->url(array("controller" => "events", "action" => "event_inquiry", "admin" => 1)); ?>';
    var page_record_length;
    var display_start;
    var categories;
    $(document).ready(function () {
        page_no = (!empty(getCookie(CONTROLLER + ACTION + 'page_no'))) ? parseInt(getCookie(CONTROLLER + ACTION + 'page_no')) + 1 : 1;
        page_limit = getCookie(CONTROLLER + ACTION + 'page_limit');
        page_sort = getCookie(CONTROLLER + ACTION + 'page_sort');
        page_record_length = !isNaN(parseInt(page_limit)) ? (parseInt(page_limit)) : 10;
        display_start = (page_record_length * page_no) - page_record_length;
        //removeCookie(CONTROLLER+ACTION+'page_no');

        table = $('#eventList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "displayStart": display_start,
            "info": true,
            "pageLength": page_record_length,
            "language": {
                "processing": "<img src='" + HTTP_ROOT + "images/ajax-loader-v2.gif'>",
                "emptyTable": "No events found"
            },
            "autoWidth": true,
            "aaSorting": page_sort ? [page_sort.split(',')] : [0, 'desc'],
            "aoColumnDefs": [
                {
                    "visible": false,
                    'searchable': false,
                    "targets": [0]
                },
                {
                    "targets": [1],
                    "render": function (data, type, row) {
                        if (row[1].length > 20)
                            return tooltip(row[1], 20, 'admin');
                        else
                            return row[1];
                    }
                }, {
                    "targets": [2],
                    "render": function (data, type, row) {
                        if (row[2].length > 20)
                            return tooltip(row[2], 20, 'admin');
                        else
                            return row[2];
                    }
                }, {
                    "targets": [3],
                    "render": function (data, type, row) {
                        
                            return format_phone_number(row[3]);
                    }
                }, {
                    "targets": [4],
                    "render": function (data, type, row) {
                        if (row[4].length > 25)
                            return tooltip(row[4], 25, 'admin');
                        else
                            return row[4];
                    }
                }, {
                    "targets": [5],
                    "render": function (data, type, row) {
                            return row[5]=='may-go'?"May Go":(row[5]=='going'?"Going":"Not Going");
                    }
                }, {
                    "targets": [6],
                    "render": function (data, type, row) {
                            return row[6];
                    }
                }, {
                    "targets": [7],
                    "render": function (data, type, row) {
                        if (row[7] && row[7] != '0000-00-00 00:00:00')
                            return moment(row[7]).format("MMM DD, YYYY");
                        else
                            return "---";
                        //return (parseInt(row[8]) == 1) ? 'Active' : 'Inactive';
                    }
                }, {
                    'sClass': 'text-center',
                    'orderable': false,
                    'searchable': false,
                    "targets": [8],
                    "data": null,
                    "render": function (data, type, row) {
                        var formatted_html = '';


                        formatted_html += '<span class="action_links"><a href="' + delete_event_url + '/' + row[0] + '" rel="tooltip" data-original-title="Delete" onclick="if (confirm(&quot;Are you sure you want to delete # ' + row[1] + '?&quot;)) { return true; } return false;"><span class="fa fa-trash-o fa-fw"></span></a></span>';
                        return formatted_html;
                    }
                }],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": ajax_url,
                "dataSrc": function (json) {
                    return json.data;
                }
            }
        });


        table.on('draw', function () {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
    });
</script>