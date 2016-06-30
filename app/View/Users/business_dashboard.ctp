<?php echo $this->Session->flash(); ?>
<div class="login">
    <div style="float:left;">
        <h2>
            <?php echo __('Hello ' . $this->session->read('Auth.User.username')) ?>
        </h2>
    </div>
    <div style="float:left;">
        <?php echo $this->Html->link('Sign Out', array('controller' => 'users', 'action' => 'logout'), array()); ?>
    </div>
    <div style="clear:both;"></div>
</div>