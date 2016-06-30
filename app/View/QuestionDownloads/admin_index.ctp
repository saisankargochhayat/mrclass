<?php
echo $this->Html->script(array('moment.min'), array('inline' => false));
?>
<section class="content-header">
    <h1>All Downloads History <?php if(!empty($extra) && $extra != "all"){echo ": ".strtoupper($qdc_data['Question']['title']);}else{echo "";}?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <?php if(!empty($extra) && $extra != "all"){?><li><a href="<?php echo $this->Html->url(array('controller' => 'questions', 'action' => 'index','all', 'admin' => 1)); ?>"> Question Banks</a></li><?php }?>
        <?php if(!empty($extra) && $extra != "all"){?><li class="active"><?php echo $qdc_data['Question']['title']; ?></li><?php }?>
        <li class="active"><?php echo __('Download History'); ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('Download History'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="downloadList" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('File Name'); ?></th>
                                <th><?php echo __('User'); ?></th>
                                <th><?php echo __('Downloaded On'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('File Name'); ?></th>
                                <th><?php echo __('User'); ?></th>
                                <th><?php echo __('Downloaded On'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
                <input type="hidden" id='fetch_quest' value="<?php echo $extra;?>">
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
var submit_stat = false;
var ajax_url = '<?php echo $this->Html->url(array("controller" => "QuestionDownloads","action" => "index","admin" => 1));?>';
$(document).ready(function() {
    table = $('#downloadList').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "language": {
            "processing": "<img src='" + HTTP_ROOT + "images/ajax-loader-v2.gif'>"
        },
        "autoWidth": true,
        "aaSorting": [0, 'desc'],
        "aoColumnDefs": [{
            "bVisible": false,
            'bSearchable': false,
            "aTargets": [0]
        }, {
        	"bVisible": (trim($('#fetch_quest').val()) == "all") ? true : false,
            'bSearchable': (trim($('#fetch_quest').val()) == "all") ? true : false,
            "aTargets": [1],
            "mRender": function(data, type, row) {
                if(row[1]){
                    if (row[1].length > 17)
                        return tooltip(row[1], 17, 'admin');
                    else
                        return row[1];
                }else{
                    return "";
                }
            }
         },{
            "aTargets": [2],
            "mRender": function(data, type, row) {
                if (row[2].length > 17)
                    return tooltip(row[2], 17, 'admin');
                else
                    return row[2];
            }
        }, {
            "aTargets": [3],
            "mRender": function(data, type, row) {
                return moment(row[3]).format("MMM DD, YYYY");
            }
        }],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": ajax_url,
            "dataSrc": function(json) {
                return json.data;
            },
            "data": function (d) {
                d.fetch = $('#fetch_quest').val();
            }
        }
    });
    table.on('draw', function() {
        var body = $(table.table().body());
        body.unhighlight();
        body.highlight(table.search());
    });
});

</script>