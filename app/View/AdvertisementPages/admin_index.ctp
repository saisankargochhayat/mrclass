<?php echo $this->Html->script(array('moment.min'), array('inline' => false)); ?>
<style type="text/css">
    .box{min-height: 450px;}
</style>
<section class="content-header">
    <h1><?php echo __('Advertisement Pages'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller' => 'advertisement_pages', 'action' => 'index', 'admin' => 1)); ?>">Advertisement Pages</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('All Advertisement Pages'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="javascript:void(0);"  id="ad_page_modal" class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus"></i>  <?php echo __('Add New Advertisement Page'); ?></a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="admin_advertisement_pages"class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('Name'); ?></th>
                                <th><?php echo __('Description'); ?></th>
                                <th><?php echo __('Created'); ?></th>
                                <th style="text-align: center;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('Name'); ?></th>
                                <th><?php echo __('Description'); ?></th>
                                <th><?php echo __('Created'); ?></th>
                                <th style="text-align: center;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </tfoot>
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
<script type="text/javascript">
    var ajax_url = '<?php echo $this->Html->url(array("controller" => "advertisement_pages","action" => "index","admin" => 1));?>';
    $(document).ready(function () {
        $('#ad_page_modal').on('click', function () {
            $('#ad_page_Name').val('');
            $('#ad_page_description').val('');
            $('#ad_page_id').val('');
            $('#ad_page_modal_box').modal();
        });
        $('#admin_advertisement_pages').on('click', '.edit_ad_page', function () {
            var id = $(this).attr('data-id');
            $('.overlay').show();
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller' => 'advertisement_pages', 'action' => 'edit', 'admin' => 1)); ?>",
                type: 'POST',
                dataType: 'json',
                data: {id: id},
                success: function (res) {
                    if (res) {
                        $('#ad_page_Name').val(res.AdvertisementPage.name);
                        $('#ad_page_description').val(res.AdvertisementPage.description);
                        $('#ad_page_id').val(res.AdvertisementPage.id);
                        $('.overlay').hide();
                        $('#ad_page_modal_box').modal();
                    }
                }
            });
        });
       table = $('#admin_advertisement_pages').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "language": {
                "lengthMenu": "Display _MENU_ records per page",
                "zeroRecords": "No advertisement pages found",
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
                        return (row[1].length > 25) ? tooltip(row[1], 25,'admin') : row[1];
                    }
                },
                {
                    "aTargets": [2],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                        if(row[2]){
                            return (row[2].length > 30) ? tooltip(row[2], 30,'admin') : row[2];
                        }else{
                            return "N/A";
                        }
                    }
                },
                {
                    "aTargets": [3],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                       if(row[3]){
                            var created_valid = moment(row[3], 'YYYY-MM-DD HH:mm:ss',true).isValid();
                            var formatted_created = (created_valid) ? moment(row[3], 'YYYY-MM-DD HH:mm:ss').format("MMM DD, YYYY") : "";
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
                    "aTargets": [4],
                    "mData": null,
                    "mRender": function (data, type, row) {
                        var formatted_html = '';
                        formatted_html += '<span class="action_links"><a href="javascript:void(0);" rel="tooltip"  class="edit_ad_page" data-id="' + row[0] + '" data-original-title="Edit"><i class="fa fa-pencil"></i> </a></span>';
                        formatted_html += '<span class="action_links"><a href="javascript:void(0);" rel="tooltip" class="delete_ad_page" data-id="' + row[0] + '" data-original-title="Delete"><span class="fa fa-trash-o fa-fw"></span></a></span>';
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
        $("#admin_advertisement_pages").on('click', '.delete_ad_page', function () {
            var id = $(this).data('id');
            if (confirm("Are You Sure want to delete the atergeted ad page  ?")) {
                $('.overlay').show();
                $.ajax({
                    type: "POST",
                    data: {id: id},
                    url: "<?php echo $this->Html->url(array('controller' => 'advertisement_pages', 'action' => 'delete', 'admin' => 1)); ?>",
                    success: function (response) {
                        $('.overlay').hide();
                        if (response) {
                            table.ajax.reload(null, false);
                        }else{
                            alert("The ad page could not be deleted. Please, try again.");
                        }
                    }
                });
            }
        });
    });
    function validate_ad_page(){
        return true;
    }
</script>
