<?php echo $this->Html->script(array('moment.min'), array('inline' => false));?>
<style type="text/css">
    .box{min-height: 450px;}
</style>
<section class="content-header">
    <h1><?php echo __('Advertisement Trackings'); ?></h1>
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
                    <h3 class="box-title"><?php echo __('All Tracks'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="advertisements_tarcking"class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('Name'); ?></th>
                                <th><?php echo __('User'); ?></th>
                                <th><?php echo __('Agent'); ?></th>
                                <th><?php echo __('Ip'); ?></th>
                                <th><?php echo __('URL'); ?></th>
                                <th><?php echo __('Created'); ?></th>
<!--                                <th style="text-align: center;"><?php echo __('Actions'); ?></th>-->
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('Name'); ?></th>
                                <th><?php echo __('User'); ?></th>
                                <th><?php echo __('Agent'); ?></th>
                                <th><?php echo __('Ip'); ?></th>
                                <th><?php echo __('URL'); ?></th>
                                <th><?php echo __('Created'); ?></th>
<!--                                <th style="text-align: center;"><?php echo __('Actions'); ?></th>-->
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<?php echo $this->Html->script(array('ua-parser.min'), array('inline' => true));?>
<script type="text/javascript">
    var ajax_url = '<?php echo $this->Html->url(array("controller" => "advertisements","action" => "tracking","admin" => 1));?>';
    $(document).ready(function () {
       table = $('#advertisements_tarcking').DataTable({
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
                        return (row[1].length > 20) ? tooltip(row[1], 20,'admin') : row[1];
                    }
                },
                {
                    "aTargets": [2],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                        return row[2] ? ((row[2].length > 20) ? tooltip(row[2], 20,'admin') : row[2]) : 'Visitor';
                    }
                },
                {
                    "aTargets": [3],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                        return getBrowserDetails(row[3]);//(row[3]) ? ((row[3] > 19) ? tooltip(row[3], 19,'admin') : row[3]) : "";
                    }
                },
                {
                    "aTargets": [4],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                        return (row[4]) ? ((row[4] > 19) ? tooltip(row[4], 19,'admin') : row[4]) : "";
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
                /*{
                    "sClass": "text-center",
                    'bSortable': false,
                    'bSearchable': false,
                    "aTargets": [7],
                    "mData": null,
                    "mRender": function (data, type, row) {
                        var formatted_html = '';
                        formatted_html += '<span class="action_links"><a href="" rel="tooltip" data-original-title="Edit"><i class="fa fa-pencil"></i> </a></span>';
                        return formatted_html;
                    }
                }*/
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
    function getBrowserDetails(ua){
        var parser  = new UAParser();
        //var ua = 'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/536.6 (KHTML, like Gecko) Chrome/20.0.1090.0 Safari/536.6';
        var x = parser.setUA(ua).getResult()
        //console.log(x)
        var name = x.browser.name;
        var major = x.browser.major;
        var ver = x.browser.version;
        var os = x.os.name;
        var osver = x.os.version;
        return name+' '+major+', '+os+' '+osver;
        //console.log(name+' '+major+' '+ver +' '+os+' '+osver);
    }
</script>
