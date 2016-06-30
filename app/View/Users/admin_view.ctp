<style>
    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td{border: 0px none;}
    .actions{float: right;}
    .actions li{display: inline-block; list-type:none; border-right: 1px solid #333; padding-right: 5px;}
</style>
<?php $user = $users; ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>User Details</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'index','admin'=>1));?>">Users</a></li>
        <li class="active">View</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <div class="fr"><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id']),array('class'=>'btn btn-block btn-primary')); ?></div>
            <?php /*?><h3 class="box-title"><?php echo h(ucwords($user['User']['name'])); ?></h3>
             <ul class="actions">
                <li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
                <li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $user['User']['id']))); ?> </li>
                <li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
            </ul><?php */?>
        </div>
        <div class="box-body">
            <table class="table">
                <tbody>
                    <tr><td class="col-sm-2"><?php echo __('Name'); ?>:</td><td class="col-sm-10"><?php echo h($user['User']['name']); ?></td></tr>
                    <tr>
                        <td class="col-sm-2"><?php echo __('Photo'); ?>:</td>
                        <td class="col-sm-10"><img src="<?php echo $this->Format->user_photo($user['User'],80,80) ?>" alt=""/></td>
                    </tr>
                    <tr><td class="col-sm-2"><?php echo __('Email'); ?>:</td><td class="col-sm-10"><?php echo h($user['User']['email']); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('Phone'); ?>:</td><td class="col-sm-10"><?php echo $this->Format->formatPhoneNumber($user['User']['phone']); ?></td></tr>
                    <tr><td class="col-sm-2"><?php echo __('City'); ?>:</td><td class="col-sm-10"><?php echo h($user['City']['name']); ?></td></tr>
                    <?php if (!empty($user['User']['google_id'])) { ?>
                        <tr><td class="col-sm-2"><?php echo __('Google id'); ?>:</td><td class="col-sm-10"><?php echo h($user['User']['google_id']); ?></td></tr>
                    <?php } ?>
                    <?php if (!empty($user['User']['facebook_id'])) { ?>
                        <tr><td class="col-sm-2"><?php echo __('Facebook id'); ?>:</td><td class="col-sm-10"><?php echo h($user['User']['facebook_id']); ?></td></tr>
                    <?php } ?>
                    <?php /*?><tr><td class="col-sm-2"><?php echo __('Pincode'); ?>:</td><td class="col-sm-10"><?php echo h($user['User']['pincode']); ?></td></tr><?php */?>
                    <tr><td class="col-sm-2"><?php echo __('Created'); ?>:</td><td class="col-sm-10"><?php echo $this->Format->dateFormat(h($user['User']['created'])); ?></td></tr>
                    <tr>
                        <td class="col-sm-2"><?php echo __('Last Login'); ?>:</td>
                        <td class="col-sm-10"><?php echo strtotime($user['User']['last_login']) > 0 ? $this->Format->dateFormat(h($user['User']['last_login'])) : "---"; ?></td>
                    </tr>
                    <tr><td class="col-sm-2"><?php echo __('Status'); ?>:</td><td class="col-sm-10"><?php echo h($user['User']['status'])==1?"Active":"Inactive"; ?></td></tr>
                    <?php /*?><tr><td class="col-sm-2"><?php echo __('Type'); ?>:</td><td class="col-sm-10"><?php echo h($user['User']['type']); ?></td></tr><?php */?>
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</section><!-- /.content -->