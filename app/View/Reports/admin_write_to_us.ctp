<?php
echo $this->Html->script(array('moment.min'), array('inline' => false));
?>
<style>
    #select2-select-container i{font-size:25px;}
    .select2-results__option{font-size:25px;}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Write to Us</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#"><?php echo __('Write to Us'); ?></a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo __('Write to Us'); ?></h3>
                    
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="facility_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width:15%;"><?php echo __('Name'); ?></th>
                                <th style="width:60%;"><?php echo __('Message'); ?></th>
                                <th style="width:15%;"><?php echo __('Sent On'); ?></th>
                                <th style="width:10%;text-align:center;"><?php echo __('Action'); ?></th>
                            </tr>
                        </thead>
                    </table>
                </div><!-- /.box-body -->
                <div class="overlay" style="display:none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<?php echo $this->element('modal'); ?>
<script>
    var tm_icon = '';
    var delete_write_to_us = '<?php echo $this->Html->url(array("controller" => "reports","action" => "write_to_us","admin" => 1));?>';
    $(document).ready(function() {
        table = $('#facility_table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "language": {
                "processing": "<img src='<?php echo HTTP_ROOT; ?>images/ajax-loader-v2.gif'>"
            },
            "autoWidth": true,
            "aaSorting": [2, 'desc'], //[0, 'asc']
            "aoColumnDefs": [
                {
                    "aTargets": [1],
                    "mRender": function (data, type, row) {
                         if (row[1].length > 90)
                            return '<span title="" rel="tooltip" data-placement="top" data-original-title="' + row[1] + '">' + row[1].substring(0, 90) + '...' + '</span>';
                        else
                            return row[1];
                    }
                },
                {
                    "aTargets": [2],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                       if(row[2]){
                            var created_valid = moment(row[2]).isValid();
                            var formatted_created = (created_valid) ? moment(row[2]).format("MMM DD, YYYY") : "";
                            return (formatted_created.length > 15) ? tooltip(formatted_created, 15,'admin') : formatted_created;
                        }else{
                            return "";
                        }
                    }
                },
                {
                    "sClass": "text-center",
                    'bSortable': false,
                    "aTargets": [3],
                    "mData": null,
                    "mRender": function (data, type, row) {
                        var formatted_html = "";
                        var is_complete = (parseInt(row[4]) == 1) ? 'restore' : 'markcomplete';
                        var title = (is_complete == 'restore') ? "Restore" : "Mark Complete";
                        formatted_html += '<span class="action_links"><a data-id="' + row[3] + '" data-state="' + is_complete + '" data-mode="writetous" id="mark_complete_conreq_' + row[3] + '" rel="tooltip" data-original-title="' + title + '" class="mark_complete_conreq anchor">';
                        formatted_html += (parseInt(row[4]) == 1) ? '<span class="ion ion-refresh"></span>' : '<span class="ion ion-checkmark"></span>';
                        formatted_html += '</a></span>';
                        formatted_html += '<span class="action_links" style="margin-left: 10px;">';
                        formatted_html += '<a href="' + delete_write_to_us + '/' + row[3] + '" rel="tooltip" data-original-title="Delete" onclick="return confirm(\'Are you sure?\');"><span class="fa fa-trash-o"></span></a>';
                        formatted_html += '</span>';
                        return formatted_html;
                    }
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": HTTP_ROOT + "reports/write_to_us_ajax",
            "createdRow": function (row, data, index) {
                if (parseInt(data[4]) == 1) {
                    $(row).addClass('restore');
                } else {
                    $(row).addClass('markcomplete');
                }
            }
        });
        table.on('draw', function() {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
    });
    var page_name = "Write to Us";
    var act_url = "<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'mark_complete')); ?>";
</script>