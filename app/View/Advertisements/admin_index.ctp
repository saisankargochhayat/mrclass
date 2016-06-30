<?php echo $this->Html->script(array('moment.min'), array('inline' => false));?>
<style type="text/css">
    .box{min-height: 450px;}
</style>
<section class="content-header">
    <h1><?php echo __('Advertisements'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller' => 'advertisements', 'action' => 'index', 'admin' => 1)); ?>">Advertisements</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('All Advertisements'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo $this->Html->url(array('controller' => 'advertisements', 'action' => 'add', 'admin' => 1)); ?>" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus"></i>  <?php echo __('Add New Advertisement'); ?></a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="admin_advertisements"class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('Name'); ?></th>
                                <th><?php echo __('Contact Name'); ?></th>
                                <th><?php echo __('Description'); ?></th>
                                <th><?php echo __('City'); ?></th>
                                <th><?php echo __('Page'); ?></th>
                                <th><?php echo __('Created'); ?></th>
                                <th><?php echo __('Status'); ?></th>
                                <th style="text-align: center;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('Name'); ?></th>
                                <th><?php echo __('Contact Name'); ?></th>
                                <th><?php echo __('Description'); ?></th>
                                <th><?php echo __('City'); ?></th>
                                <th><?php echo __('Page'); ?></th>
                                <th><?php echo __('Created'); ?></th>
                                <th><?php echo __('Status'); ?></th>
                                <th style="text-align: center;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
    var view_booking_url = '<?php echo $this->Html->url(array("controller" => "reports","action" => "group_booking_requests","admin" => 1));?>';
    var edit_business_url = '<?php echo $this->Html->url(array("controller" => "advertisements","action" => "edit","admin" => 1));?>';
    var delete_business_url = '<?php echo $this->Html->url(array("controller" => "advertisements","action" => "delete","admin" => 1));?>';
    var ajax_url = '<?php echo $this->Html->url(array("controller" => "advertisements","action" => "index","admin" => 1));?>';
    $(document).ready(function () {
       table = $('#admin_advertisements').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "language": {
                "lengthMenu": "Display _MENU_ records per page",
                "zeroRecords": "No advertisements found",
                "processing": "<img src='<?php echo HTTP_ROOT; ?>images/ajax-loader-v2.gif'>",
                "infoEmpty":"Nothing found - sorry",
                "info": "Showing page _PAGE_ of _PAGES_",
            },
            "autoWidth": true,
            "aaSorting": [0, 'desc'],//[0, 'desc']
            "aoColumnDefs": [
                { "bVisible": false,'bSearchable': false,  "aTargets": [0] },
                {
                    "aTargets": [1],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                        return (row[1].length > 14) ? tooltip(row[1], 14,'admin') : row[1];
                    }
                },
                {
                    "aTargets": [2],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                        return (row[2].length > 20) ? tooltip(row[2], 20,'admin') : row[2];
                    }
                },
                {
                    "aTargets": [3],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                        return (row[3]) ? ((row[3] > 19) ? tooltip(row[3], 19,'admin') : row[3]) : "";
                    }
                },
                {
                    "aTargets": [5],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                        return tooltip(row[5], 15,'admin');
                    }
                },
                {
                    "aTargets": [6],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                       if(row[6]){
                            var created_valid = moment(row[6], 'YYYY-MM-DD HH:mm:ss',true).isValid();
                            var formatted_created = (created_valid) ? moment(row[6], 'YYYY-MM-DD HH:mm:ss').format("MMM DD, YYYY") : "";
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
                        return (_.parseInt(row[7])) ? "Active" : "Inactive";
                    }
                },
                {
                    "sClass": "text-center",
                    'bSortable': false,
                    'bSearchable': false,
                    "aTargets": [8],
                    "mData": null,
                    "mRender": function (data, type, row) {
                        var formatted_html = '';
                        formatted_html += '<span class="action_links"><a href="' + edit_business_url + '/' + row[0] + '" rel="tooltip" data-original-title="Edit"><i class="fa fa-pencil"></i> </a></span>';
                        formatted_html += '<span class="action_links"><a href="' + delete_business_url + '/' + row[0] + '" rel="tooltip" data-original-title="Delete" onclick="if (confirm(&quot;Are you sure you want to delete # ' + row[1] + '?&quot;)) { return true; } return false;"><span class="fa fa-trash-o fa-fw"></span></a></span>';
                        return formatted_html;
                    }
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": ajax_url
        });
        table.on('draw', function () {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
    });
    function validate_ad_page(){
        return true;
    }
</script>
