<?php 
$page_name = isset($this->params['pass'][1]) ? h($this->params['pass'][1]) : ""; 
$BusinessId = isset($this->request->data['Business']['id']) ? h($this->request->data['Business']['id']) : $this->params['pass'][0];
$options['conditions'] = array('Business.id'=>$BusinessId);
$options['recursive'] = -1;
$business_data = $this->Format->get_business_list_business($BusinessId , $options,'first');
$btype = $business_data['Business']['type'];
?>
<ul class="nav nav-tabs">
    <li class="<?php if ($page_name == 'info') { echo 'active'; } ?>">
        <a href="<?php echo $this->Html->url(array("controller" => "businesses", "action" => "edit", "admin" => 1, $BusinessId, "info")); ?>"><?php echo __('Edit Business'); ?></a>
    </li>
    <?php /*if($btype == "private") {?>
    <li class="<?php if ($page_name == 'additional_info') { echo 'active'; } ?>">
        <a href="<?php echo $this->Html->url(array("controller" => "businesses", "action" => "edit", "admin" => 1, $BusinessId, "additional_info")); ?>"><?php echo __('Additional Info'); ?></a>
    </li>
    <?php } */?>
    <li class="<?php if ($page_name == 'venue') { echo 'active'; } ?>">
        <a href="<?php echo $this->Html->url(array("controller" => "businesses", "action" => "edit", "admin" => 1, $BusinessId, "venue")); ?>"><?php echo __('Venue'); ?></a>
    </li>
    <li class="<?php if ($page_name == 'contact') { echo 'active'; } ?>">
        <a href="<?php echo $this->Html->url(array("controller" => "businesses", "action" => "edit", "admin" => 1, $BusinessId, "contact")); ?>"><?php echo __('Contact details'); ?></a>
    </li>
    <li class="<?php if ($this->params['controller'] == 'business_galleries' && $page_name == 'pics') { echo 'active'; } ?>">
        <a href="<?php echo $this->Html->url(array("controller" => "business_galleries", "action" => "add", "admin" => 1,$BusinessId,"pics")); ?>"><?php echo __('Gallery'); ?></a>
    </li>
    <li class="<?php if ($this->params['controller'] == 'business_galleries'&& $page_name == 'vids') { echo 'active'; } ?>">
        <a href="<?php echo $this->Html->url(array("controller" => "business_galleries", "action" => "add_video_link", "admin" => 1,$BusinessId,"vids")); ?>"><?php echo __('Videos'); ?></a>
    </li>
    <li class="<?php if ($this->params['controller'] == 'business_timings'&& $page_name == 'btimings') { echo 'active'; } ?>">
        <a href="<?php echo $this->Html->url(array("controller" => "business_timings", "action" => "add", "admin" => 1,$BusinessId,"btimings")); ?>"><?php echo __('Timings'); ?></a>
    </li>
    <li class="<?php if ($this->params['controller'] == 'business_ratings' && $page_name == 'bratings') { echo 'active'; } ?>">
        <a href="<?php echo $this->Html->url(array("controller" => "business_ratings", "action" => "index", "admin" => 1,$BusinessId,"bratings")); ?>"><?php echo __('Reviews & Ratings'); ?></a>
    </li>
    <li class="<?php if ($this->params['controller'] == 'BusinessFaqs' && $page_name == 'bfaqs') { echo 'active'; } ?>">
        <a href="<?php echo $this->Html->url(array("controller" => "BusinessFaqs", "action" => "index", "admin" => 1,$BusinessId,"bfaqs")); ?>"><?php echo __('Business Faqs'); ?></a>
    </li>
    <li class="<?php if ($this->params['controller'] == 'businesses' && $page_name == 'courses') { echo 'active'; } ?>">
        <a href="<?php echo $this->Html->url(array("controller" => "businesses", "action" => "courses", "admin" => 1, $BusinessId, "courses")); ?>"><?php echo __('Courses'); ?></a>
    </li>
</ul>