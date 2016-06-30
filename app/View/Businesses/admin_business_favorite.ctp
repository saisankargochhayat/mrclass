<?php
echo $this->Html->script(array('moment.min'), array('inline' => false));
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Favorite businesses</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#"><?php echo __('Favorites'); ?></a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo __('Businesses marked as favorite by users'); ?></h3>
                    
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="bfavorites_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width:15%;"><?php echo __('ID'); ?></th>
                                <th style="width:15%;"><?php echo __('Business Name'); ?></th>
                                <th style="width:15%;"><?php echo __('User Name'); ?></th>
                                <th style="width:15%;"><?php echo __('Email'); ?></th>
                                <th style="width:15%;"><?php echo __('Phone'); ?></th>
                                <th style="width:15%;"><?php echo __('Created'); ?></th>
                                <th style="width:15%;"><?php echo __('Action'); ?></th>
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
    var ajax_url = '<?php echo $this->Html->url(array("controller" => "businesses","action" => "business_favorite","admin" => 1));?>';
    $(document).ready(function() {
        table = $('#bfavorites_table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "language": {
                "processing": "<img src='<?php echo HTTP_ROOT; ?>images/ajax-loader-v2.gif'>"
            },
            "autoWidth": true,
            "aaSorting": [0, 'desc'], //[0, 'asc']
            "aoColumnDefs": [
                {
                    "bVisible": false,
                    'bSearchable': false,
                    "aTargets": [0]
                },
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
                    "mRender": function (data, type, row) {
                         if (row[2].length > 50)
                            return tooltip(row[2], 50,'admin');
                        else
                            return row[2];
                    }
                },
                {
                    "aTargets": [3],
                    "mRender": function (data, type, row) {
                        if(row[3]){
                            return (row[3].length > 22) ? tooltip(row[3], 22,'admin') : row[3];
                        }else{
                            return "N/A";
                        }
                    }
                },
                {
                    "aTargets": [4],
                    "mRender": function (data, type, row) {
                        if(row[4]){
                            var phone_number = format_phone_number(row[4]);
                            return (phone_number.length > 22) ? tooltip(phone_number, 22,'admin') : phone_number;
                        }else{
                            return "N/A";
                        }
                    }
                },
                {
                    "aTargets": [5],
                    "mRender": function (data, type, row) {
                         if(row[5]){
                            var created_valid = moment(row[5], 'YYYY-MM-DD HH:mm:ss',true).isValid();
                            var formatted_created = (created_valid) ? moment(row[5], 'YYYY-MM-DD HH:mm:ss').format("MMM DD, YYYY") : "";
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
                    "aTargets": [6],
                    "mData": null,
                    "mRender": function (data, type, row) {
                        var formatted_html = "";
                        var is_complete = (parseInt(row[6]) == 1) ? 'restore' : 'markcomplete';
                        var title = (is_complete == 'restore') ? "Restore" : "Mark Complete";
                        formatted_html += '<span class="action_links"><a data-id="' + row[0] + '" data-state="' + is_complete + '" data-mode="business_favorites" id="mark_complete_conreq_' + row[0] + '" rel="tooltip" data-original-title="' + title + '" class="mark_complete_conreq anchor">';
                        formatted_html += (parseInt(row[6]) == 1) ? '<span class="ion ion-refresh"></span>' : '<span class="ion ion-checkmark"></span>';
                        formatted_html += '</a></span>';
                        return formatted_html;
                    }
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": ajax_url,
            "createdRow": function (row, data, index) {
                if (parseInt(data[6]) == 1) {
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
    page_name = "Business Favorite";
    act_url = "<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'mark_complete')); ?>";
</script>