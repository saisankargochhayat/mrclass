<section class="content-header">
    <h1><?php echo ucfirst(strtolower(str_replace('_', ' ', $actions))); ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'index','admin'=>1));?>"><?php echo substr($actions, 4).'s'; ?></a></li>
        <li><?php echo ucfirst(strtolower(str_replace('_', ' ', $actions))); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#userAdd" data-toggle="tab"><?php echo ucfirst(strtolower(str_replace('_', ' ', $actions))); ?></a></li>
                    <!--<li><a href="#userAdd" data-toggle="tab">Timeline</a></li>-->
                    <!--<li><a href="#userAdd" data-toggle="tab">Settings</a></li>-->
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="userAdd">
                  <?php echo $this->Form->create('User',array('action'=>'add','admin'=>1,'class'=>'form-horizontal','autocomplete' => 'off')); ?>
                        <div class="form-group">
                            <label for="UserName" class="col-sm-2 control-label"><?php echo __('Name'); ?></label>
                            <div class="col-sm-10">
                          <?php echo $this->Form->input('name',array('label'=>false,'div'=>false,'placeholder'=>'Name','class'=>'form-control alphaOnly'));?>
                            </div>
                        </div>
                        <?php /*?><div class="form-group">
                            <label for="UserUsername" class="col-sm-2 control-label"><?php echo __('Username'); ?></label>
                            <div class="col-sm-10">
                            <?php echo $this->Form->input('username',array('label'=>false,'div'=>false,'placeholder'=>'Username','class'=>'form-control'));?>
                            </div>
                        </div><?php */?>
                        <div class="form-group">
                            <label for="UserEmail" class="col-sm-2 control-label"><?php echo __('Email'); ?></label>
                            <div class="col-sm-10">
                          <?php echo $this->Form->input('email',array('label'=>false,'div'=>false,'placeholder'=>'Email','class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UserPassword" class="col-sm-2 control-label"><?php echo __('Password'); ?></label>
                            <div class="col-sm-10">
                          <?php echo $this->Form->input('password',array('label'=>false,'div'=>false,'placeholder'=>'Password','class'=>'form-control nospace'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UserPasswordConfirm" class="col-sm-2 control-label"><?php echo __('Confirm Password'); ?></label>
                            <div class="col-sm-10">
                          <?php echo $this->Form->input('password_confirm',array('type'=>'password','label'=>false,'div'=>false,'placeholder'=>'Password','class'=>'form-control nospace'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UserPhone" class="col-sm-2 control-label"><?php echo __('Phone'); ?></label>
                            <div class="col-sm-10">
                                <div class="phoneblock fl">
                                    <div class="phlbl fl">+91</div>
                                    <?php echo $this->Form->input('phone', array('label' => false, 'div' => false, 'placeholder' => 'Phone', 'class' => 'form-control numbersOnly', 'maxlength' => 10, 'error' => false)); ?>
                                </div>
                                <div class="error" id="UserPhoneErr"><?php  echo $this->Form->error('phone', null, array('class' => 'error-message'));?></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="UserCity" class="col-sm-2 control-label"><?php echo __('City'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('city', array('options' => $cities, 'label' => false, 'div' => false, 'data-placeholder' => 'Select City', 'class' => 'form-control select2')); ?>
                            </div>
                        </div>
                        <?php /*?><div class="form-group">
                            <label for="UserPincode" class="col-sm-2 control-label"><?php echo __('Pincode'); ?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('pincode',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'pincode','class'=>'form-control numbersOnly','maxlength'=>6));?>
                            </div>
                        </div><?php */?>
                        <?php echo $this->Form->input('actions',array('type'=>'hidden','value'=>$actions));?>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-success" onclick="admin_add_user_valid('');"><?php echo __('Submit'); ?></button>
                            </div>
                            <?php /*?><div class="col-sm-offset-2 col-sm-10">
                                <a class="btn btn-danger" href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'index', 'admin' => 1));?>"><?php echo __('Cancel'); ?></a>
                            </div><?php */?>
                        </div>
                       <?php echo $this->Form->end(); ?>
                    </div><!-- /.tab-pane -->

                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
    $(document).ready(function () {
        admin_add_user_valid('mode');
        $(".nospace").on("keydown", function(e) {
            if (e.which === 32 && !this.value.length)
            e.preventDefault();
        });
    });
</script>    
<script>
    $(".select2").select2();
</script>