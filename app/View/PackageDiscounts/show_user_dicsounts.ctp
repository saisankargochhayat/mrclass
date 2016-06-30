<div class="grey-box">
  <?php $cntr = 0; ?>
 <?php foreach($package_prices as $k=>$v){?>
      <div class="each-row">
        <div class="fl check-btn">
        <?php if($cntr > 0){?>
          <input type="radio" data-month="<?php echo $v['package_month'];?>" class="radio1" name="discount" value="<?php echo $v['discount_id'];?>"/>
        <?php }else{ ?>
          <input type="radio" data-month="<?php echo $v['package_month'];?>" class="radio1" name="discount"  value="<?php echo $v['discount_id'];?>" checked/>
        <?php } ?>
        </div>
        <div class="fl month_name"><?php echo $v['package_month'];?> month</div>
        <div class="fl amount">Rs <?php printf("%.2f", $v['total_price']);?></div>
        <?php /* ?><div class="fl amount">Rs <?php printf("%.2f", $v['total_discounted_price_pm']);?><?php if($cntr == 0){echo "";}else{echo "/mo";}?></div>
        <div class="fl p-amount" style="<?php if($cntr == 0){echo "text-decoration:none;";}else{echo "";}?>">Rs <?php printf("%.2f",$v['total_package_price']);?>/mo</div><?php */ ?>
        <?php if($cntr > 0){?>
          <div class="fl sale-on"><?php echo $v['total_discount_text'];?>
        <?php }else{ ?>
          <div class="fl sale-on">Rs <?php printf("%.2f", $v['total_price']);?>
        <?php } ?>
       <?php /* ?>(save <?php echo $v['total_discount_percentage'];?>)<?php */ ?></div>
        <div class="cb"></div>
      </div>
	  <?php $cntr++;?>
  <?php }?>
</div>
</div>
