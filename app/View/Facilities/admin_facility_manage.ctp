<style>
    #select2-select-container i{font-size:25px;}
    .select2-results__option{font-size:25px;}
    .icons{font-size: 33px;}
</style>
<?php #echo $this->Html->css(array('select2.min'), array('block' => 'bootstrap_datatable_css')); ?>
<?php #echo $this->Html->script(array('select2.full.min'), array('block' => 'demojs'));?>
<?php echo $this->Html->css(array('plugins/colorpicker/bootstrap-colorpicker.min.css'), array('block' => 'bootstrap_datatable_css')); ?>
<?php echo $this->Html->script(array('plugins/colorpicker/bootstrap-colorpicker.min.js'), array('block' => 'demojs')); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Manage Facilities</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#"><?php echo __('Facilities'); ?></a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo __('Facilities'); ?></h3>
                    <div class="box-tools pull-right">
                        <a href="javascript:void(0)" class="btn btn-block btn-primary btn-sm" id="facility_modal"><i class="fa fa-plus"></i>  <?php echo __('Add Facility'); ?></a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="facility_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo __('Name'); ?></th>
                                <th style="text-align:center;"><?php echo __('Icon'); ?></th>
                                <th style="text-align:center;"><?php echo __('Color'); ?></th>
                                <?php /* ?><th><?php echo __('Created'); ?></th><?php */ ?>
                                <th style="text-align:center;width:10%;"><?php echo __('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php $cnt = 0; ?>
                            <?php foreach ($facilities as $facility):
                                ?>
                                <tr>
                                    <td><?php echo h($facility['Facility']['name']); ?>&nbsp;</td>
                                    <td style="text-align:center;">
                                        <span title="<?php echo h($facility['Facility']['name']); ?>" 
                                              class="<?php echo strtolower(h($facility['Facility']['name'])); ?>">
                                                  <?php echo $this->Format->format_facility_icon($facility['Facility']['image'], 'icons'); ?>
                                        </span>&nbsp;
                                    </td>
                                    <td style="text-align:center;"><?php echo h($facility['Facility']['color'] != '' ? $facility['Facility']['color'] : "NA"); ?>&nbsp;</td>
                                    <?php /* ?><td><?php echo h($this->Format->dateFormat($facility['Facility']['created'])); ?>&nbsp;</td><?php */ ?>
                                    <td style="text-align:center;">
                                        <span class="action_links">
                                            <a href="javascript:void(0);" id="edit_fac_<?php echo $facility['Facility']['id']; ?>" class="edit_fac" rel='tooltip' data-original-title='Edit facility' data-id="<?php echo $facility['Facility']['id']; ?>"><i class="fa fa-pencil"></i> </a>
                                        </span>
                                        <span class="action_links">
                                            <?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'fa fa-trash-o')) . "", array('controller' => 'facilities', 'action' => 'facility_delete', 'admin' => 1, $facility['Facility']['id']), array('escape' => false, 'class' => 'tip-top', 'data-toggle' => 'tooltip', 'data-original-title' => 'Delete', 'confirm' => __('Are you sure you want to delete # %s?', $facility['Facility']['name']))); ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php $cnt++; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?php echo __('Name'); ?></th>
                                <th style="text-align:center;"><?php echo __('Icon'); ?></th>
                                <?php /* ?><th><?php echo __('Created'); ?></th><?php */ ?>
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
<script>
    var tm_icon = '';
    $(document).ready(function() {
        $(".my-colorpicker2").colorpicker();
        var table = $('#facility_table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "aaSorting": [[0, 'asc']],
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [1, 2]},
            ]
        });
        table.on('draw', function() {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
        $('#facility_table').on('click', '.edit_fac', function() {
            var id = $(this).attr('data-id');
            $('.overlay').show();
            $.ajax({
                url: "<?php echo $this->Html->url(array('controller' => 'facilities', 'action' => 'edit_facility', 'admin' => 1)); ?>",
                type: 'POST',
                dataType: 'json',
                data: {id: id},
                success: function(res) {
                    if (res) {
                        $('#edit_facility_name').val(res.Facility.name);
                        $('#edit_facility_color').val(res.Facility.color);
                        $("#edit_facility_select").select2("val", "<i class='" + res.Facility.image + "'></i>");
                        $('#facility_id').val(res.Facility.id);
                        $('.overlay').hide();
                        $('#edit_facility').modal();
                        tm_icon = res.Facility.image;
                    }
                }
            });
        });

        $('#facility_modal').on('click', function() {
            $('#facilityModal').modal();
        });

        $('#select,#edit_facility_select').select2({
            placeholder: "Select a icon",
            allowClear: true,
            escapeMarkup: function(m) {
                return m;
            }
        });
        $('#select').change(function() {
            var str = $('#select').val();
            var pattern = /'(.*?)'/;
            var result = str.match(pattern);
            $('#user_icon_class_val').val(result[1]);
        });
        $('#edit_facility_select').on('change', function() {
            var str_edit = $('#edit_facility_select').val();
            var pattern_1 = /'(.*?)'/;
            var result_edit = str_edit.match(pattern_1);
            typeof result_edit != 'undefined' && result_edit !== null ? $('#edit_user_icon_class_val').val(result_edit[1]) : '';
        });
        $("#facilityModal").on('show.bs.modal', function() {
            $('#facility_Name').val('');
        });
        $.ajax({
            url: "<?php echo $this->Html->url(array('controller' => 'facilities', 'action' => 'get_facility_icons', 'admin' => 1)); ?>",
            type: 'POST',
            dataType: 'json',
            data: {},
            success: function(res) {
                if (res) {
                    for (var key in res) {
                        var newOption = "<option>&lt;i class='" + res[key].Icon.name + "'&gt;&lt;/i&gt;</option>";
                        $("#select,#edit_facility_select").append(newOption);
                    }
                }
            }
        });

    });
</script>