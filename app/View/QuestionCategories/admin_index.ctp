<?php
echo $this->Html->script(array('moment.min'), array('inline' => false));
?>
<section class="content-header">
    <h1>Manage Question Bank Categories</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo __('Question Bank Categories'); ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('Categories'); ?></h3>
                    <div class="box-tools pull-right" style="position:initial;">
                    <a href="javascript:void(0);" style="display:inline-block;margin-right:5px;" class="btn btn-flat btn-primary btn-sm pull-left" id="add_cat_ques_modal">  <?php echo str_replace('_', ' ', 'Add_Category'); ?></a>
                        <a href="<?php echo $this->Html->url(array("controller" => "questions","action" => "index","all","admin" => 1));?>" class="btn btn-flat btn-primary btn-sm pull-right" style="display:inline-block;padding:5px 0">&nbsp;&nbsp;See all question banks&nbsp;&nbsp;</a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="questioncategoryList" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('Name'); ?></th>
                                <th><?php echo __('Description'); ?></th>
                                <th><?php echo __('No Of Files'); ?></th>
                                <th><?php echo __('Created On'); ?></th>
                                <th style="text-align:center;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('Name'); ?></th>
                                <th><?php echo __('Description'); ?></th>
                                <th><?php echo __('No Of Files'); ?></th>
                                <th><?php echo __('Created On'); ?></th>
                                <th style="text-align:center;"><?php echo __('Actions'); ?></th>
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
var submit_stat = false;
var ajax_url = '<?php echo $this->Html->url(array("controller" => "question_categories","action" => "index","admin" => 1));?>';
var question_banks_url = '<?php echo $this->Html->url(array("controller" => "questions","action" => "index","admin" => 1));?>';
$(document).ready(function() {
    $('#add_cat_ques_modal').on('click', function() {
        reset_elements();
        $('#add_cat_ques_modal_box').modal().on('hidden.bs.modal', function(e) {
            $('#QuestionCategoryAddForm').validate().resetForm();
            reset_elements();
        });
    });
    table = $('#questioncategoryList').DataTable({
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
            "aTargets": [1],
            "mRender": function(data, type, row) {
                if (row[1].length > 17)
                    return tooltip(row[1], 17, 'admin');
                else
                    return row[1];
            }
        }, {
            "aTargets": [2],
            "mRender": function(data, type, row) {
                if (row[2].length > 45)
                    return tooltip(row[2], 45, 'admin');
                else
                    return row[2];
            }
        }, {
            "aTargets": [4],
            "mRender": function(data, type, row) {
                return moment(row[4]).format("MMM DD, YYYY");
            }
        }, {
            "sClass": "text-center",
            'bSortable': false,
            'bSearchable': false,
            "aTargets": [5],
            "mData": null,
            "mRender": function(data, type, row) {
                var formatted_html = '';
                 formatted_html += '<span class="action_links"><a href="'+question_banks_url+'/index/'+row[0]+'" data-id="' + row[0] + '" rel="tooltip" class="ques_cat_view" data-original-title="View all question banks"><i class="fa fa-eye"></i> </a></span>';
                formatted_html += '<span class="action_links"><a href="javascript:void(0);" data-id="' + row[0] + '" rel="tooltip" class="ques_cat_edit" data-original-title="Edit"><i class="fa fa-pencil"></i> </a></span>';
                formatted_html += '<span class="action_links"><a href="javascript:void(0);" rel="tooltip" data-original-title="Delete" class="ques_cat_del" data-name="' + row[1] + '" data-id="' + row[0] + '"><span class="fa fa-trash-o fa-fw"></span></a></span>';
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

    $("#questioncategoryList").on('click', '.ques_cat_del', function() {
        var id = $(this).data('id');
        if (confirm("This will delete all the question banks and associated download history. Are You Sure want to delete the question bank category folder " + $(this).data('name') + " ?")) {
            $('.overlay').show();
            $.ajax({
                type: "POST",
                data: {
                    id: id
                },
                url: "<?php echo $this->Html->url(array('controller' => 'question_categories', 'action' => 'delete', 'admin' => 1)); ?>",
                success: function(response) {
                    if (response) {
                        $('.overlay').hide();
                        table.ajax.reload(null, false);
                    } else {
                        alert("The category could not be deleted. Please, try again.");
                    }
                }
            });
        }
    });

    $("#questioncategoryList").on('click', '.ques_cat_edit', function() {
        var id = $(this).data('id');
        edit_template(id);
    });
});

function validate_ad_q_cat() {
    var validate = $('#QuestionCategoryAddForm').validate({
        rules: {
            'data[QuestionCategory][name]': {
                required: true
            },
        },
        messages: {
            'data[QuestionCategory][name]': {
                required: "Please enter category name.",
            },
        },
        errorPlacement: function(error, element) {
            if (element.attr("id") == "ad_q_cat_Name") {
                error.appendTo($("#ad_q_cat_Name_error"));
            } else {
                error.insertAfter(element);
            }
        }

    });
    $('#QuestionCategoryAddForm').removeAttr("novalidate");
    if (validate.form()) {
        if (submit_stat) {
            return false;
        }
        $('#add_q_cat_button').html('Saving..');
        submit_stat = true;
        var frm = $('#QuestionCategoryAddForm');
        var data = frm.serializeArray();
        $.ajax({
            type: "POST",
            url: "<?php echo $this->Html->url(array('controller' => 'question_categories', 'action' => 'add', 'admin' => 1)); ?>",
            data: data,
            dataType: "json",
            success: function(response) {
                submit_stat = false;
                $("#add_cat_ques_modal_box").modal("hide");
                if (response.status) {
                    table.ajax.reload(null, false);
                    alert('Question category saved.');
                } else {
                    alert('Sorry. Question category can not be saved.');
                }
            }
        });
    } else {
        $('input.error').eq(0).focus();
    }
}

function edit_template(id) {
    if (typeof id !== "undefined") {
        $('.overlay').show();
        $.ajax({
            url: "<?php echo $this->Html->url(array('controller' => 'question_categories', 'action' => 'edit', 'admin' => 1)); ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id: id
            }
        }).done(function(response) {
            if (response) {
                $('.overlay').hide();
                reset_elements();
                $('#ad_ques_cat_form_header').html('Update Question Category');
                $('#ad_q_cat_Name').val(response.name);
                $('#ad_q_cat_id').val(response.id);
                $('#ad_q_cat_description').val(response.description);
                $('#add_q_cat_button').html("Update");
                $('#add_cat_ques_modal_box').modal();
            } else {
                alert('Invalid category.');
            }
        });
    } else {
        alert("Invalid Category !");
    }
}

function reset_elements() {
    $('#ad_ques_cat_form_header').html('Add Question Category');
    $('#ad_q_cat_Name').val('');
    $('#ad_q_cat_id').val('');
    $('#ad_q_cat_description').val('');
    $('#add_q_cat_button').html('Save');
    
}
</script>