<?php
echo $this->Html->script(array('moment.min'), array('inline' => false));
?>
<style type="text/css">
    .box{        min-height: 450px;    }
</style>
<section id="ajax_div">
    <section class="content-header">
        <h1><?php echo __('Feedbacks'); ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'feedbacks', 'admin' => 1)); ?>">User Feedbacks</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo __('All User Feedbacks'); ?></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="admin_feedbacks"class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><?php echo __('ID'); ?></th>
                                    <th><?php echo __('Created'); ?></th>
                                    <th><?php echo __('User'); ?></th>
                                    <th><?php echo __('Email'); ?></th>
                                    <th><?php echo __('Feedback'); ?></th>
                                    <th><?php echo __('Comment'); ?></th>
                                    <th style="text-align: center;"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</section><!-- /.ajax_div -->
<script type="text/javascript">
    $(document).ready(function () {
        table = $('#admin_feedbacks').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "language": {
                "processing": "<img src='<?php echo HTTP_ROOT; ?>images/ajax-loader-v2.gif'>"
            },
            "autoWidth": true,
            "aaSorting": [0, 'desc'], //[0, 'desc']
            "aoColumnDefs": [
                { "bVisible": false,  "aTargets": [0] },
                {
                    "aTargets": [1],
                    'bSearchable': true,
                    "mRender": function (data, type, row) {
                        if(row[1]){
                            var created_valid = moment(row[1]).isValid();
                            var formatted_created = (created_valid) ? moment(row[1]).format("MMM DD, YYYY") : "";
                            return (formatted_created.length > 20) ? tooltip(formatted_created, 20,'admin') : formatted_created;
                        }else{
                            return "";
                        }
                    }
                },
                {
                    "aTargets": [5],
                    "mRender": function (data, type, row) {
                        if (row[5].length > 20)
                            return tooltip(row[5], 20,'admin');
                        else
                            return row[5];
                    }
                },
                {
                    "sClass": "text-center",
                    'bSortable': false,
                    "aTargets": [6],
                    "mData": null,
                    "mRender": function (data, type, row) {
                        var formatted_html = "";
                        var is_complete = (parseInt(row[6]) == 1) ? 'restore' : 'markcomplete';
                        var title = (is_complete == 'restore') ? "Restore" : "Mark Complete";
                        formatted_html += '<span class="action_links"><a data-id="' + row[0] + '" data-state="' + is_complete + '" data-mode="feedback" id="mark_complete_conreq_' + row[0] + '" rel="tooltip" data-original-title="' + title + '" class="mark_complete_conreq anchor">';
                        formatted_html += (parseInt(row[6]) == 1) ? '<span class="ion ion-refresh"></span>' : '<span class="ion ion-checkmark"></span>';
                        formatted_html += '</a></span>';
                        formatted_html += '<span class="action_links" style="margin-left: 10px;">';
                        formatted_html += '<a href="javascript:void(0)" data-id="' + row[0] + '" rel="tooltip" data-username="' + row[2] + '" class="admin_del_feed" data-original-title="Delete Feedback"><span class="fa fa-trash-o"></span> </a>';
                        formatted_html += '</span>';
                        return formatted_html;
                    }
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": HTTP_ROOT + "reports/feedbacks_ajax",
            "createdRow": function (row, data, index) {
                if (parseInt(data[6]) == 1) {
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
        $("#admin_feedbacks").on('click', '.admin_del_feed', function () {
            var id = $(this).data('id')
            if (confirm("Are You Sure want to delete the feedback from " + $(this).data('username') + " ?")) {
                window.location.href = "<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'delete_feedbacks', 'admin' => 1)); ?>/" + id;
                return false;
                $.ajax({
                    type: "POST",
                    data: {id: id},
                    url: "<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'delete_feedbacks', 'admin' => 1)); ?>",
                    success: function (response) {
                        if (response) {
                            $('#ajax_div').html(response);
                            //table.ajax.reload(null, false);
                        }
                    }
                });
            }
        });
    });
    var page_name = "feedback";
    var act_url = "<?php echo $this->Html->url(array('controller' => 'reports', 'action' => 'mark_complete')); ?>";
</script>
