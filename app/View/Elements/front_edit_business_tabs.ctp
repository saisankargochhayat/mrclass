<div class="cb20"></div>
<div class="tab-update-details">
    <ul>
        <li <?php if($parms['controller'] == 'businesses' && $parms['action'] == 'edit' && ($parms['slug'] == 'details' || $parms['slug'] == '')){ echo 'class="active"';}?>>
            <a href="<?php echo $this->Html->url("/edit-business-" . $BusinessId . "-details"); ?>">Business Details 
                <div class="arrow-down-tab"></div>
            </a>
        </li>
        <li <?php if($parms['controller'] == 'businesses' && $parms['action'] == 'edit' && $parms['slug'] == 'venue'){ echo 'class="active"';}?>>
            <a href="<?php echo $this->Html->url("/edit-business-" . $BusinessId . "-venue"); ?>">Venue
                <div class="arrow-down-tab"></div>
            </a>
        </li>
        <li <?php if($parms['controller'] == 'businesses' && $parms['action'] == 'edit' && $parms['slug'] == 'contact-info'){ echo 'class="active"';}?>>
            <a href="<?php echo $this->Html->url("/edit-business-" . $BusinessId . "-contact-info"); ?>">Contact Details
                <div class="arrow-down-tab"></div>
            </a>
        </li>
        <li <?php if($parms['controller'] == 'business_galleries' && $parms['action'] == 'add'){ echo 'class="active"';}?>>
            <a href="<?php echo $this->Html->url("/business-pics-" . $BusinessId . "-change"); ?>">Gallery
                <div class="arrow-down-tab"></div>
            </a>
        </li>
        <li <?php if($parms['controller'] == 'business_galleries' && $parms['action'] == 'add_video_link'){ echo 'class="active"';}?>>
            <a href="<?php echo $this->Html->url("/business-videos-" . $BusinessId . "-change"); ?>">Videos
                <div class="arrow-down-tab"></div>
            </a>
        </li>
        <li <?php if($parms['controller'] == 'business_timings' && $parms['action'] == 'add'){ echo 'class="active"';}?>>
            <a href="<?php echo $this->Html->url("/business-timing-" . $BusinessId . "-change"); ?>">Timing
                <div class="arrow-down-tab"></div>
            </a>
        </li>
		<li <?php if(($parms['controller'] == 'businessFaqs' || $parms['controller'] == "BusinessFaqs") && ($parms['action'] == 'index' || $parms['action'] == 'add' || $parms['action'] == 'edit')){ echo 'class="active"';}?>>
            <a href="<?php echo $this->Html->url("/business-faq-" . $BusinessId . "-change"); ?>">Faqs
                <div class="arrow-down-tab"></div>
            </a>
        </li>
        <li <?php if($parms['controller'] == 'Businesses' && $parms['action'] == 'courses'){ echo 'class="active"';}?>>
            <a href="<?php echo $this->Html->url("/business-courses-" . $BusinessId . "-change"); ?>">Courses
                <div class="arrow-down-tab"></div>
            </a>
        </li>
    </ul>
</div>