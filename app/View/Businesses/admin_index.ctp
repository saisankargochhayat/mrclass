<?php echo $this->Html->script(array('moment.min'), array('inline' => false)); ?>
<section class="content-header">
    <h1>Manage Businesses</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo __('Businesses'); ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('Businesses'); ?></h3>
                    <div class="box-tools pull-right" style="position:initial;width:220px">
                        <a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'add', 'admin' => 1)); ?>" class="btn btn-flat btn-primary btn-sm pull-left" style="display:inline-block;width:100px;"><i class="ion ion-person-add"></i>  <?php echo str_replace('_', ' ', 'Add_Business'); ?></a>
                        <a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'export_modal', 'admin' => 1)); ?>" data-toggle="modal" data-target="#myExportModal" class="btn btn-flat btn-primary btn-sm pull-right" style="display:inline-block;width:100px;margin-top:0;padding:5px 0"><i class="fa fa-file-excel-o"></i>  <?php echo "Export"; ?></a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="businessList" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('Name'); ?></th>
                                <th><?php echo __('Category'); ?></th>
                                <th><?php echo __('City'); ?></th>
                                <th><?php echo __('Address'); ?></th>
                                <th><?php echo __('Contact Person'); ?></th>
                                <th><?php echo __('Created On'); ?></th>
                                <th><?php echo __('Status'); ?></th>
                                <th style="text-align:center;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('Name'); ?></th>
                                <th><?php echo __('Category'); ?></th>
                                <th><?php echo __('City'); ?></th>
                                <th><?php echo __('Address'); ?></th>
                                <th><?php echo __('Contact Person'); ?></th>
                                <th><?php echo __('Created On'); ?></th>
                                <th><?php echo __('Status'); ?></th>
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
var grant_business_url = '<?php echo $this->Html->url(array("controller" => "businesses","action" => "grant_business","admin" => 1));?>';
var edit_business_url = '<?php echo $this->Html->url(array("controller" => "businesses","action" => "edit","admin" => 1));?>';
var delete_business_url = '<?php echo $this->Html->url(array("controller" => "businesses","action" => "delete","admin" => 1));?>';
var ajax_url = '<?php echo $this->Html->url(array("controller" => "businesses","action" => "index_ajax","admin" => 0));?>';
var page_record_length;
var display_start;
var categories;
$(document).ready(function() {
    page_no = (!empty(getCookie(CONTROLLER + ACTION + 'page_no'))) ? parseInt(getCookie(CONTROLLER + ACTION + 'page_no')) + 1 : 1;
    page_limit = getCookie(CONTROLLER + ACTION + 'page_limit');
    page_sort = getCookie(CONTROLLER + ACTION + 'page_sort');
    page_record_length = !isNaN(parseInt(page_limit)) ? (parseInt(page_limit)) : 10;
    display_start = (page_record_length * page_no) - page_record_length;
    //removeCookie(CONTROLLER+ACTION+'page_no');

    table = $('#businessList').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "displayStart": display_start,
        "info": true,
        "pageLength": page_record_length,
        "language": {
            "processing": "<img src='"+HTTP_ROOT+"images/ajax-loader-v2.gif'>"
        },
        "autoWidth": true,
        "aaSorting": page_sort ? [page_sort.split(',')] : [7, 'desc'],
        "aoColumnDefs": [
        {
            "bVisible": false,
            'bSearchable': false,
            "aTargets": [0]
        },
         {
            "aTargets": [1],
            "mRender": function(data, type, row) {
                if (row[1].length > 17)
                    return tooltip(row[1], 17,'admin');
                else
                    return row[1];
            }
        }, {
            "aTargets": [2],
            'bSortable': false,
            //'bSearchable': false,
            "mRender": function(data, type, row) {
                if (row[2].length > 15)
                    return tooltip(row[2], 15,'admin');
                else
                    return row[2];
            }
        }, {
            "aTargets": [4],
            "mRender": function(data, type, row) {
                 if (row[4].length > 25)
                        return tooltip(row[4], 25,'admin');
                    else
                        return row[4];
                //return format_address(row[3], row[8], row[9], row[10], row[11]);
            }
        }, {
            "aTargets": [5],
            "mRender": function(data, type, row) {
                if (row[5].length > 20)
                    return tooltip(row[5], 20,'admin');
                else
                    return row[5];
            }
          }, {
            "aTargets": [6],
            "mRender": function(data, type, row) {
                return moment(row[6]).format("MMM DD, YYYY");
            }  
        }, {
            "aTargets": [7],
            "mRender": function(data, type, row) {
                return (parseInt(row[7]) == 1) ? 'Active' : 'Inactive';
            }
        }, {
            "sClass": "text-center",
            'bSortable': false,
            'bSearchable': false,
            "aTargets": [8],
            "mData": null,
            "mRender": function(data, type, row) {
                var formatted_html = '';
                var allowed = (!empty(row[13]) && parseInt(row[13]) && (trim(row[12]) == "Premium")) ? "Yes" : "No";
                var BusinessUrl = format_business_url(row[0], row[1], row[14], true, allowed);
                var tooltip_text = (parseInt(row[7]) == 1) ? 'Deactivate Business' : 'Activate Business';
                var stat_class = (parseInt(row[7]) !== 1) ? ' green-ico' : ' red-ico';
                formatted_html += '<span class="action_links"><a href="' + grant_business_url + '/' + row[0] + '" rel="tooltip" data-original-title="' + tooltip_text + '" class="'+stat_class+'">';
                formatted_html += (parseInt(row[7]) == 1) ? ' <i class="fa fa-ban fa-fw"></i>' : ' <i class="fa fa-check-square-o fa-fw"></i>';
                formatted_html += '</a></span>';
                formatted_html += '<span class="action_links"><a href="' + edit_business_url + '/' + row[0] + '/info" rel="tooltip" data-original-title="Edit"><i class="fa fa-pencil"></i> </a></span>';
                formatted_html += '<span class="action_links"><a href="' + delete_business_url + '/' + row[0] + '" rel="tooltip" data-original-title="Delete" onclick="if (confirm(&quot;Are you sure you want to delete # ' + row[1] + '?&quot;)) { return true; } return false;"><span class="fa fa-trash-o fa-fw"></span></a></span>';
                formatted_html += '<span class="action_links"><a href="' + BusinessUrl + '" target="_blank" class="fa fa-eye" title="View"></a></span>'
                return formatted_html;
            }
        }],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": ajax_url,
            "dataSrc": function(json) {
                return json.data;
            }
        }
    });


    table.on('draw', function() {
        var body = $(table.table().body());
        body.unhighlight();
        body.highlight(table.search());
    });
});
var format_address = function(city, locality, address, landmark, zip) {
    var address_text = address + "," + "\n" + (trim(landmark) != '' ? landmark + "," : "") + "\n" + locality + "," + "\n" + city + "," + "\n" + zip;
    return tooltip(address_text, 20,'admin');
};
</script>