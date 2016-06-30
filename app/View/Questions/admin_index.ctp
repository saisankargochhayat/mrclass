<?php
echo $this->Html->css(array('bootstrap-editable'), array('inline' => false));
echo $this->Html->script(array('moment.min', 'bootstrap-editable.min'), array('inline' => false));
?>
<section class="content-header">
    <h1>Question Bank <?php echo (!empty($extra) && $extra != "all") ? ": " . strtoupper($qbc_data['QuestionCategory']['name']) : ""; ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <?php if (!empty($extra) && $extra != "all") { ?><li><a href="<?php echo $this->Html->url(array('controller' => 'questionCategories', 'action' => 'index', 'admin' => 1)); ?>"> Question Bank Categories</a></li><?php } ?>
        <?php if (!empty($extra) && $extra != "all") { ?><li class="active"><?php echo $qbc_data['QuestionCategory']['name']; ?></li><?php } ?>
        <li class="active"><?php echo __('Question Bank'); ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo __('Files'); ?></h3>
                    <?php if (!empty($extra) && $extra != "all") { ?>
                        <div class="box-tools pull-right" style="position:initial;">
                            <a href="<?php echo $this->Html->url(array("controller" => "questions", "action" => "question_bank_upload", $qbc_data['QuestionCategory']['id'], "admin" => 1)); ?>" style="display:inline-block;margin-right:5px;" class="btn btn-flat btn-primary btn-sm pull-left">  <?php echo str_replace('_', ' ', 'Upload_question_bank'); ?></a>
                        </div>
                    <?php } ?>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="questionList" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="text-align:center;"><?php echo __('ID'); ?></th>
                                <th><?php echo __('Sequence'); ?></th>
                                <th><?php echo __('Title'); ?></th>
                                <th><?php echo __('File Name'); ?></th>
                                <th><?php echo __('Description'); ?></th>
                                <th><?php echo __('No Of Downloads'); ?></th>
                                <th><?php echo __('Created On'); ?></th>
                                <th style="text-align:center;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th><?php echo __('ID'); ?></th>
                                <th><?php echo __('Sequence'); ?></th>
                                <th><?php echo __('Title'); ?></th>
                                <th><?php echo __('File Name'); ?></th>
                                <th><?php echo __('Description'); ?></th>
                                <th><?php echo __('No Of Downloads'); ?></th>
                                <th><?php echo __('Created On'); ?></th>
                                <th style="text-align:center;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
                <div class="overlay" style="display:none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <input type="hidden" id='fetch_quest' value="<?php echo $extra; ?>">
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<?php echo $this->element('modal'); ?>
<script type="text/javascript">
    var submit_stat = false;
    var ajax_url = '<?php echo $this->Html->url(array("controller" => "questions", "action" => "index", "admin" => 1)); ?>';
    var history_url = '<?php echo $this->Html->url(array("controller" => "QuestionDownloads", "action" => "index", "admin" => 1)); ?>';
    var save_seq_url = '<?php echo $this->Html->url(array("controller" => "questions", "action" => "save_sequence", "admin" => 1)); ?>';
    $(document).ready(function () {
        $.fn.editable.defaults.mode = 'popover';
        table = $('#questionList').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "language": {
                "processing": "<img src='" + HTTP_ROOT + "images/ajax-loader-v2.gif'>"
            },
            "autoWidth": true,
            "aaSorting": (trim($('#fetch_quest').val()) == "all") ? [0, 'desc'] : [1, 'asc'],
            "aoColumnDefs": [{
                    "bVisible": false,
                    'bSearchable': false,
                    "aTargets": [0]
                }, {
                    "aTargets": [1],
                    "bVisible": (trim($('#fetch_quest').val()) == "all") ? false : true,
                    'bSearchable': (trim($('#fetch_quest').val()) == "all") ? false : true,
                    "createdCell": function (td, cellData, rowData, row, col) {
                        (trim($('#fetch_quest').val()) != "all") ? init_editable(td) : "";
                    },
                    "mRender": function (data, type, row) {
                        if (row[1])
                            return '<a href="#" class="editable editable-click status_link" data-type="text" data-url="' + save_seq_url + '" data-pk="' + row[0] + '" rel="tooltip" data-name="sequence" data-value="' + row[1] + '" title="Change file sequence">' + row[1] + '</a>';
                        else
                            return "N/A";
                    }
                }, {
                    "aTargets": [2],
                    "mRender": function (data, type, row) {
                        if (row[2].length > 17)
                            return tooltip(row[2], 17, 'admin');
                        else
                            return row[2];
                    }
                }, {
                    "aTargets": [3],
                    "mRender": function (data, type, row) {
                        if (row[3].length > 17)
                            return tooltip(row[3], 17, 'admin');
                        else
                            return row[3];
                    }
                }, {
                    "aTargets": [3],
                    "mRender": function (data, type, row) {
                        if (row[3].length > 17)
                            return tooltip(row[3], 17, 'admin');
                        else
                            return row[3];
                    }
                }, {
                    "aTargets": [4],
                    "createdCell": function (td, cellData, rowData, row, col) {
                        (rowData[4]) ? "" : $(td).css('text-align', 'center');
                    },
                    "mRender": function (data, type, row) {
                        return (row[4]) ? ((row[4].length > 30) ? tooltip(row[4], 30, 'admin') : row[4]) : "N/A";
                    }
                }, {
                    "aTargets": [5],
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css('text-align', 'center')
                    },
                    "mRender": function (data, type, row) {
                        return (parseInt(row[5])) ? '<div class="btn-group-vertical"><a href="' + history_url + '/index/' + row[0] + '" rel="tooltip" data-original-title="View download history" class="btn btn-default">' + row[5] + '</a></div>' : '<div class="btn-group-vertical"><a href="javascript:void(0);" rel="tooltip" data-original-title="No download history available" class="btn btn-default">' + row[5] + '</a></div>';
                    }
                }, {
                    "aTargets": [6],
                    "mRender": function (data, type, row) {
                        return moment(row[6]).format("MMM DD, YYYY");
                    }
                }, {
                    "sClass": "text-center",
                    'bSortable': false,
                    'bSearchable': false,
                    "aTargets": [7],
                    "mData": null,
                    "mRender": function (data, type, row) {
                        var formatted_html = '';
                        formatted_html += '<span class="action_links"><a href="javascript:void(0);" data-id="' + row[0] + '" data-qcid="' + row[8] + '" rel="tooltip" class="ques_cat_edit" data-original-title="Edit"><i class="fa fa-pencil"></i> </a></span>';
                        formatted_html += '<span class="action_links"><a href="javascript:void(0);" rel="tooltip" data-original-title="Delete" class="ques_cat_del" data-qcid="' + row[8] + '" data-name="' + row[3] + '" data-id="' + row[0] + '"><span class="fa fa-trash-o fa-fw"></span></a></span>';
                        return formatted_html;
                    }
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": ajax_url,
                "dataSrc": function (json) {
                    return json.data;
                },
                "data": function (d) {
                    d.fetch = $('#fetch_quest').val();
                }
            }
        });


        table.on('draw', function () {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });

        $("#questionList").on('click', '.ques_cat_del', function () {
            var id = $(this).data('id');
            var cat_id = $(this).data('qcid');
            var file_name = $(this).attr('data-name');
            if (confirm("Are You Sure want to delete the package " + $(this).data('name') + " ?")) {
                $('.overlay').show();
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    data: {
                        id: id,
                        cat_id: cat_id,
                        file_name: file_name
                    },
                    url: "<?php echo $this->Html->url(array('controller' => 'questions', 'action' => 'delete', 'admin' => 1)); ?>",
                    success: function (response) {
                        if (response.status) {
                            $('.overlay').hide();
                            table.ajax.reload(null, false);
                        } else {
                            alert(response.reponseTest);
                        }
                    }
                });
            }
        });

        $("#questionList").on('click', '.ques_cat_edit', function () {
            var id = $(this).data('id');
            if (typeof id !== "undefined") {
                $('.overlay').show();
                reset_elements();
                $.ajax({
                    url: "<?php echo $this->Html->url(array('controller' => 'questions', 'action' => 'edit', 'admin' => 1)); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {id: id}
                }).done(function (response) {
                    if (response) {
                        $('.overlay').hide();
                        $('#ad_q_Name').val(response.title);
                        $('#ad_q_id').val(response.id);
                        $('#ad_q_description').val(response.description);
                        $('#add_ques_modal_box').modal().on('hidden.bs.modal', function (e) {
                            $('#QuestionAddForm').validate().resetForm();
                            reset_elements();
                        });
                    } else {
                        alert('Invalid Question Bank.');
                    }
                });
            } else {
                alert("Invalid Category !");
            }
        });
    });

    function validate_ad_q() {
        var validate = $('#QuestionAddForm').validate({
            rules: {
                'data[Question][title]': {
                    required: true
                },
            },
            messages: {
                'data[Question][title]': {
                    required: "Please enter title.",
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("id") == "ad_q_Name") {
                    error.appendTo($("#ad_q_Name_error"));
                } else {
                    error.insertAfter(element);
                }
            }

        });
        if (validate.form()) {
            if (submit_stat) {
                return false;
            }
            $('#add_q_button').html('Updating..');
            submit_stat = true;
            var frm = $('#QuestionAddForm');
            var data = frm.serializeArray();
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller' => 'questions', 'action' => 'add', 'admin' => 1)); ?>",
                data: data,
                dataType: "json",
                success: function (response) {
                    submit_stat = false;
                    $("#add_ques_modal_box").modal("hide");
                    if (response.status) {
                        table.ajax.reload(null, false);
                        alert('Question bank information updated.');
                    } else {
                        alert('Sorry. Question category can not be saved.');
                    }
                }
            });
        } else {
            $('input.error').eq(0).focus();
        }
    }

    function reset_elements() {
        $('#ad_ques_form_header').html('Update Question Bank Details');
        $('#ad_q_Name').val('');
        $('#ad_q_id').val('');
        $('#ad_q_description').val('');
        $('#add_q_button').html('Update');
    }
    function init_editable(obj) {
        var action_link = $(obj).find('.status_link');
        $(action_link).editable({
            title: 'Enter sequence',
            placement: 'top',
            validate: function (value) {
                if ($.trim(value) == '')
                    return 'This field is required';
                if ($.isNumeric(value) == '')
                    return 'Only numbers are allowed';
            },
            ajaxOptions: {
                dataType: 'json'
            },
            display: function (value, response) {
                $(this).html(value);
            },
            success: function (response, newValue) {
                if (!response) {
                    return "Unknown error!";
                }
                if (response.success === false) {
                    return response.responseText;
                }
            },
            error: function (response, newValue) {
                if (response.status === 500) {
                    return 'Service unavailable. Please try later.';
                } else {
                    return response.responseText;
                }
            }
        });
    }
</script>