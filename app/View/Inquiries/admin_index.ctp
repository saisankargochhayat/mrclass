<?php
echo $this->Html->script(array('moment.min'), array('inline' => false));
?>
<section class="content-header">
    <h1>Manage <?php echo __('Looking for a Tutor'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a><?php echo __('Looking for a Tutor'); ?></a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('All Looking for a Tutor'); ?></h3>
                    <div class="box-tools pull-right hide">
                        <a href="<?php echo $this->Html->url(array('controller' => 'inquiries', 'action' => 'add', 'admin' => 1)); ?>" class="btn btn-block btn-primary btn-sm" data-target="#InquiryAddModal" data-toggle="modal"><i class="fa fa-plus"></i>  <?php echo __('Add Inquiry'); ?></a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('Name'); ?></th>
                                <th><?php echo __('Phone'); ?></th>
                                <th><?php echo __('Email'); ?></th>
                                <th><?php echo __('Category'); ?></th>
                                <th><?php echo __('Comment'); ?></th>
                                <th><?php echo __('Created'); ?></th>
                                <th class="actions"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>

                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<?php echo $this->element('modal'); ?>
<script type="text/javascript">
    var equiry_view_url = '<?php echo $this->Html->url(array("controller" => "inquiries","action" => "view","admin" => 1));?>';
    var equiry_delete = '<?php echo $this->Html->url(array("controller" => "inquiries","action" => "delete","admin" => 1));?>';
    $(document).ready(function () {
        table = $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "language": {
                "processing": "<img src='<?php echo HTTP_ROOT; ?>images/ajax-loader-v2.gif'>"
            },
            "autoWidth": true,
            "aaSorting": [0, 'desc'], //[1, 'asc']
            "aoColumnDefs": [
            { "bVisible": false,  "aTargets": [0] },
                {
                    "aTargets": [5],
                    "mRender": function (data, type, row) {
                        if (row[5].length > 45)
                            return tooltip(row[5], 45,'admin');
                        else
                            return row[5];
                    }
                },
                {
                    "aTargets": [6],
                    "mRender": function (data, type, row) {
                        if(row[6]){
                            var created_valid = moment(row[6]).isValid();
                            var formatted_created = (created_valid) ? moment(row[6]).format("MMM DD, YYYY") : "";
                            return (formatted_created.length > 20) ? tooltip(formatted_created, 20,'admin') : formatted_created;
                        }else{
                            return "";
                        }
                    }
                },
                {
                    "sClass": "text-center action_links",
                    'bSortable': false,
                    "aTargets": [7],
                    "mData": null,
                    "mRender": function (data, type, row) {
                        var formatted_html = "";
                        var is_complete = (parseInt(row[7]) == 1) ? 'restore' : 'markcomplete';
                        var title = (is_complete == 'restore') ? "Restore" : "Mark Complete";
                        formatted_html += '<a data-id="' + row[0] + '" data-state="' + is_complete + '" data-mode="inquiry" id="mark_complete_conreq_' + row[0] + '" rel="tooltip" data-original-title="' + title + '" class="mark_complete_conreq anchor">';
                        formatted_html += (parseInt(row[7]) == 1) ? '<span class="ion ion-refresh"></span>' : '<span class="ion ion-checkmark"></span>';
                        formatted_html += '</a>';
                        formatted_html += '<a style="margin-left: 10px;" href="' + equiry_view_url + '/' + row[0] + '" rel="tooltip" data-original-title="View Enquiry" class="fa fa-eye"></a>';
                        formatted_html += '<a style="margin-left: 10px;" href="' + equiry_delete + '/' + row[0] + '" rel="tooltip" data-original-title="Delete" onclick="return confirm(\'Are you sure you want to delete the looking for a tutor request ?\');"><span class="fa fa-trash-o fa-fw"></span></a>';
                        return formatted_html;
                    }
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": HTTP_ROOT + "inquiries/enquiries_ajax",
            "createdRow": function (row, data, index) {
                if (parseInt(data[7]) == 1) {
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
        $('#InquiryAddModal').on('hidden.bs.modal', function () {
            $(this).data('bs.modal', null);
        });
    });
    var page_name = "inquiry";
    var act_url = "<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'mark_complete')); ?>";
</script>

