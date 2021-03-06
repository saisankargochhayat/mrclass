<div class="users form">
    <?php echo $this->Form->create('User',array('autocomplete' => 'off')); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php
        echo $this->Form->input('name');
        echo $this->Form->input('username');
        echo $this->Form->input('email');
        echo $this->Form->input('password');
        echo $this->Form->input('phone');
        echo $this->Form->input('verification_code');
        echo $this->Form->input('type');
        echo $this->Form->input('city');
        echo $this->Form->input('pincode');
        echo $this->Form->input('photo');
        echo $this->Form->input('last_login');
        echo $this->Form->input('status');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
    </ul>
</div>
