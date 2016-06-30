<style>
    .cmn_btn_n{display: inline-block; width:auto}
    .none{display:none;}
</style>
<div class="sup_bg log_sup" style="padding: 50px;">
    <div class="reg_mc" style="margin-top: 0px; margin: 0px auto; width: 90%;">
        <?php if(empty($this->params['prefix'])){?>
            <h1>Oops! Probably you're trying to access a page which does not exist!</h1>
            <div class="cb20"></div>
            <div class="cat_frm" style="margin: 0 auto; text-align: center;">
                <a class="cmn_btn_n anchor none" id="gobackbtn" onclick="window.history.back();"><i class="ion ion-arrow-left-c"></i>&nbsp;&nbsp;Go Back</a>
                <a class="cmn_btn_n anchor" href="<?php echo $this->Html->url('/');?>" style="margin-left:25px;">Go to Home Page</a>
            </div>
            
        <?php }else{?>
            <h1>400: <?php echo $message; ?></h1>
            <p class="error">
                <strong><?php echo __d('cake', 'Error'); ?>: </strong>
                <?php
                #printf(__d('cake', 'The requested address %s was not found on this server.'), "<strong>'{$url}'</strong>");
                printf(__d('cake', 'The requested address %s was not found on this server.'), "");
                ?>
                <div class="cb">&nbsp;</div>
                <a id="none" onclick="window.history.back();" class="btn btn-primary btn-sm none" style="display: inline-block; width:auto;"><i class="ion ion-arrow-left-c"></i>&nbsp;&nbsp;Go Back</a>
                <a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>" class="btn btn-primary btn-sm" style="display: inline-block; width:auto; margin-left:10px;">Go to Dashboard</a>
            </p>
            <?php
            if (Configure::read('debug') > 0):
                echo $this->element('exception_stack_trace');
            endif;
            ?>
        <?php } ?>
    </div>
</div>
<script>
    (window.history.length > 1)?$('#gobackbtn').show():'';
</script>