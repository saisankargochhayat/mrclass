<div class="header">
    <div class="wrapper">
        <div class="fl lft_head">
            <?php
            if (!isset($params['admin']) && $this->Session->read('Auth.User.id') > 0 && $this->Session->read('Auth.User.type') != '1') {
                $home_url = HTTP_ROOT.'dashboard';
            }else{
                $home_url = HTTP_ROOT;
            }
            ?>
            <div class="top_logo">
                <?php echo $this->Html->image("logo.png", array('alt' => Configure::read('COMPANY.NAME'), 'width' => '230', 'height' => '', 'url' => HTTP_ROOT)); ?>
            </div>
            <div class="top_menu">
                <ul>
                    <li <?php if(($parms['controller'] == 'content' && $parms['action'] == 'home') || ($parms['controller'] == 'users' && $parms['action'] == 'dashboard')){ echo 'class="active"';}?>>
                        <a class="main-uc home_icn_n"  href="<?php echo HTTP_ROOT; ?>" title="Go to Homepage"></a>
                    </li>
                    <?php /*?><li <?php if($parms['controller'] == 'content' && $parms['action'] == 'static_page' && $parms['extra'] == 'about_us'){ echo 'class="active"';}?>>
                        <a class="main-uc"  href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'static_page', 'about_us')) ?>">About</a>
                    </li><?php */?>
                    <li <?php if($parms['controller'] == 'content' && $parms['action'] == 'faq'){ echo 'class="active"';}?>>
                        <a class=""  href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'faq')) ?>">FAQs</a>
                    </li>
                    <li class="sub_menu <?php if($parms['controller'] == 'content' && $parms['action'] == 'categories'){ echo 'active';}?>">
                        <a class="main-uc anchor">Categories</a>
                        <div class="categorylist">
                            <span class="sub-arrow-top"></span>
                            <ul>   
                            <?php if(!empty($topcategories) && is_array($topcategories)) {  $cntr=0;?>
                                <?php foreach ($topcategories as $key => $cat) { ?>
                                    <?php /*<li><a href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'categories', 'id' => $key, 'slug' => $this->Format->seo_url($cat))) ?>"><?php echo $cat; ?></a></li>*/?>
                                    <?php /*<li><a href="<?php echo HTTP_ROOT.'c-'.$key.'-'.$this->Format->seo_url($cat) ?>"><?php echo $cat; ?></a></li>*/?>
                                    <?php if($cntr > 0 && $cntr%4 == 0){ echo "</ul><ul >";} $cntr++;?>
                                    <li <?php echo $cntr%4 ?>><a href="<?php echo HTTP_ROOT.'search/#cid='.$key ?>"><?php echo $cat; ?></a></li>
                                <?php } ?>
                            <?php } ?>
                            <li>
                                <a data-href="<?php echo $this->Html->url('/businesses/group_booking/')?>" onclick="event.preventDefault();" class="anchor ajax">
                                   <input class="cmn_btn_n" value="Group Booking" type="button" style="font-size:14px;padding:5px 34px;"/>
                                </a>
                                <?php /*<a data-href="<?php echo $this->Html->url('/businesses/group_booking/')?>" onclick="event.preventDefault();" class="anchor ajax cmn_btn_n ">Group Booking</a>*/?>
                            </li>
                            <?php if($this->params['action'] == 'home'){ ?>
                                    <li><input class="cmn_btn_n srart_discovering" value="Start Discovering" type="button" style="font-size:14px;"/></li>
                            <?php }else{ ?>
                                    <li><input class="cmn_btn_n" onclick="javascript:window.location.href='<?php echo HTTP_ROOT;?>#discover'" value="Start Discovering" type="button" style="font-size:14px;"/></li>
                            <?php } ?>
                            </ul>
                        </div>
                    </li>
                    <li <?php if($parms['controller'] == 'QuestionCategories' && $parms['action'] == 'index'){ echo 'class="active"';}?>>
                        <a href="<?php echo $this->Html->url(array('controller' => 'QuestionCategories', 'action' => 'index')) ?>/">Question Bank</a>
                    </li>
                    <li <?php if($parms['controller'] == 'content' && $parms['action'] == 'blog'){ echo 'class="active"';}?>>
                        <a class="main-uc"  href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'blog')) ?>/">Blog</a>
                    </li>
                    <li <?php if($parms['controller'] == 'content' && $parms['action'] == 'event_list'){ echo 'class="active"';}?>>
                        <a class="main-uc"  href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'event_list')) ?>/">Events</a>
                    </li>
                </ul>
            </div>
            <div class="cb"></div>
        </div>
		<div class="fr small-menu">
			<div class="switch_list_icn">
				<a class="list_view viewblockstoggle anchor" data-view="list"></a>
			</div>
		</div>
        <div class="fr rt_head">
            <div class="con_social fl">
                <ul>
                    <?php /*<li>
                        <a href="<?php echo Configure::read('COMPANY.FACEBOOK'); ?>" class="fb"></a>
                        <a href="<?php echo Configure::read('COMPANY.TWITTER'); ?>" class="tweet"></a>
                        <a href="<?php echo Configure::read('COMPANY.LINKEDIN'); ?>" class="lin"></a>
                        <a href="<?php echo Configure::read('COMPANY.GPLUS'); ?>" class="gplus"></a>
                        <a href="<?php echo Configure::read('COMPANY.YOUTUBE'); ?>" class="ytube"></a>
                    </li> */ ?>
                    <li><span class="top_ph_num"><?php echo Configure::read('COMPANY.TOLLFREE'); ?></span></li>
                     <?php if ($this->Session->read('Auth.User')) {?>
                        <li style="padding-left: 17px;" class="take-to-top">Welcome <?php $user_arr = @explode(' ',$user['name']); echo $user_arr[0]; ?>!</li>
                    <?php }else{?>
                        <li class="info_li">
                            <a href="mailto:<?php echo Configure::read('COMPANY.SUPPORT_EMAIL'); ?>"><?php echo Configure::read('COMPANY.SUPPORT_EMAIL'); ?></a>
                        </li>
                    <?php }?>
                    <?php if ($this->Session->read('Auth.User.id') > 0) {?>
                    <li>					
                        <span class="prof_m_span">
                            <a class="anchor top-user-image" style="background:none" id="open_popup">
                                    <img src="<?php echo HTTP_ROOT; ?>images/grey-arrow.png" class="dw-aro" />
                                    <img src="<?php echo $this->Format->user_photo($this->Session->read('Auth.User'),40,40,1); ?>" alt="User" style=""/>
                            </a>

                            <div class="popup_profile" style="min-width:330px;">
                                <div class="arrow-top"><img src="<?php echo HTTP_ROOT; ?>images/form/profile_arrow.png" /></div>
                                <div class="others">How others see you as...</div>
                                <div class="cb"></div>
                                <div class="fl pro_pix">
                                    <a href="<?php echo HTTP_ROOT; ?>edit-profile" title="Change Image">
                                        <img src="<?php echo $this->Format->user_photo($this->Session->read('Auth.User'),92,92); ?>" />
                                    </a>
                                </div>
                                <div class="fr pro_details">
                                    <div class="pro-name header-user-dtls" style="height:auto;">
                                        <a class="usr-lbl" href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'dashboard')) ?>">
                                            <?php  echo $this->Session->read('Auth.User.name');?>
                                        </a>
                                            <div class="extr-lbl"><?php  echo $this->Session->read('Auth.User.email'); ?></div>
                                            <div class="extr-lbl"><?php  echo $this->Format->formatPhoneNumber($this->Session->read('Auth.User.phone'));?></div>
                                            <div class="extr-lbl"><?php  echo $this->Session->read('Auth.User.City.name');?></div>
                                        <div class="cb10"></div>
                                    </div>
                                </div>
                                <div class="cb"></div>
                                <div class="signout">
                                        <div class="" style="border-top:1px solid #ddd;border-bottom:1px solid #ddd;margin:0 -15px;background:#fafafa;padding:15px;">
                                            <span class="grey-btn-new">
                                                <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'dashboard')); ?>" class="cmn_btn_n">Go to Dashboard</a>
                                            </span>
                                        </div>
                                        <div class="cb10"></div>
                                        <span class="grey-btn fl"><a href="<?php echo HTTP_ROOT; ?>edit-profile" class="cmn_btn_n">Edit Profile</a></span>
                                        <span class="grey-btn fl"><a href="<?php echo HTTP_ROOT; ?>favorites" class="cmn_btn_n">Favorites</a></span>
                                        <span class="grey-btn fr"><a href="<?php echo HTTP_ROOT; ?>logout" class="cmn_btn_n">Logout</a></span>
                                        <div class="cb"></div>
                                </div>
                            </div>
                        </span>

                    </li>
                    <?php }?>
                </ul>
            </div>
            <div class="top_log_reg fr">
                <ul>
                    <?php if ($this->Session->read('Auth.User.id') > 0) { /*?>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'edit',$user['id'])) ?>">Edit Profile</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'logout')) ?>">Logout</a></li>
                    <?php */ } else { ?>
                        <li <?php if($parms['controller'] == 'users' && $parms['action'] == 'sign_up'){ echo 'class="active"';}?>>
                            <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'sign_up')) ?>">Sign Up</a>
                        </li>
                        <li class="btn_top"><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'login')) ?>">Sign In</a></li>
                    <?php } ?>
                </ul>
            </div>
			<div class="cb"></div>
        </div>
        <div class="cb"></div>

        <div class="socialside">
            <ul>
                <?php if(Configure::read('COMPANY.FACEBOOK')!=''){ ?>
                    <li><a target="_blank" href="<?php echo Configure::read('COMPANY.FACEBOOK'); ?>" class="f-color"> <img src="<?php echo HTTP_ROOT; ?>images/form/facebook.png" alt="facebook" /></a></li>
                <?php } ?>
                <?php if(Configure::read('COMPANY.TWITTER')!=''){ ?>
                    <li><a target="_blank" href="<?php echo Configure::read('COMPANY.TWITTER'); ?>" class="t-color"> <img src="<?php echo HTTP_ROOT; ?>images/form/twitter.png" alt="twitter"  /></a></li>
                <?php } ?>
                <?php if(Configure::read('COMPANY.GPLUS')!=''){ ?>
                    <li><a target="_blank" href="<?php echo Configure::read('COMPANY.GPLUS'); ?>" class="g-color"> <img src="<?php echo HTTP_ROOT; ?>images/form/google_plus.png" alt="google plus"  /></a></li>
                <?php } ?>
                <?php if(Configure::read('COMPANY.LINKEDIN')!=''){ ?>
                    <li><a target="_blank" href="<?php echo Configure::read('COMPANY.LINKEDIN'); ?>" class="l-color"> <img src="<?php echo HTTP_ROOT; ?>images/form/linkedin.png" alt="linkedin"  /></a></li>
                <?php } ?>
                <?php if(Configure::read('COMPANY.YOUTUBE')!=''){ ?>
                    <li><a target="_blank" href="<?php echo Configure::read('COMPANY.YOUTUBE'); ?>" class="u-color"> <img src="<?php echo HTTP_ROOT; ?>images/form/youtube.png" alt="youtube"  /></a></li>
                <?php } ?>
            </ul>
        </div>
		
            <div class="m-screen-menu">
                <ul>
                    <li <?php if(($parms['controller'] == 'content' && $parms['action'] == 'home') || ($parms['controller'] == 'users' && $parms['action'] == 'dashboard')){ echo 'class="active"';}?>>
                        <a class="main-uc"  href="<?php echo $home_url; ?>">Home</a>
                    </li>
                    <li <?php if($parms['controller'] == 'content' && $parms['action'] == 'faq'){ echo 'class="active"';}?>>
                        <a class=""  href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'faq')) ?>">FAQs</a>
                    </li>
                    <li class="sub_menu <?php if($parms['controller'] == 'content' && $parms['action'] == 'categories'){ echo 'active';}?>">
                        <a class="main-uc anchor">Categories</a>
                        <ul>
                            <?php if(!empty($topcategories) && is_array($topcategories)) { ?>
                                <?php foreach ($topcategories as $key => $cat) { ?>
                                    <?php /*<li><a href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'categories', 'id' => $key, 'slug' => $this->Format->seo_url($cat))) ?>"><?php echo $cat; ?></a></li>*/?>
                                    <?php /*<li><a href="<?php echo HTTP_ROOT.'c-'.$key.'-'.$this->Format->seo_url($cat) ?>"><?php echo $cat; ?></a></li>*/?>
                                    <li><a href="<?php echo HTTP_ROOT.'search/#cid='.$key ?>"><?php echo $cat; ?></a></li>
                                <?php } ?>
                            <?php } ?>
							
                          <?php if($this->params['action'] == 'home'){ ?>
                                    <li><input class="cmn_btn_n srart_discovering" value="Start Discovering" type="button" style="font-size:14px;color:#fff"/></li>
                            <?php }else{ ?>
                                    <li><input class="cmn_btn_n" onclick="javascript:window.location.href='<?php echo HTTP_ROOT;?>#discover'" value="Start Discovering" type="button" style="font-size:14px;color:#fff"/></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li <?php if($parms['controller'] == 'QuestionCategories' && $parms['action'] == 'index'){ echo 'class="active"';}?>>
                        <a href="<?php echo $this->Html->url(array('controller' => 'QuestionCategories', 'action' => 'index')) ?>/" class="main-uc">Question Bank</a>
                    </li>
                    <li <?php if($parms['controller'] == 'content' && $parms['action'] == 'blog'){ echo 'class="active"';}?>>
                        <a class="main-uc"  href="<?php echo $this->Html->url(array('controller' => 'content', 'action' => 'blog')) ?>">Blog</a>
                    </li>
                </ul>

                <ul>
                     <?php if ($this->Session->read('Auth.User')) {?>
                        <li>
                                <a><img src="<?php echo HTTP_ROOT; ?>images/phone.png" alt="phone" width="13" height="14" /> <?php echo Configure::read('COMPANY.TOLLFREE'); ?></a>
                                <div style="color:#fff;padding-top:10px;padding-left:10px;">
                                        Welcome <?php $user_arr = @explode(' ',$user['name']); echo $user_arr[0]; ?>!
                                </div>
                        </li>
                    <?php }else{?>
                        <li><a><img src="<?php echo HTTP_ROOT; ?>images/phone.png" alt="phone" width="13" height="14" /> <?php echo Configure::read('COMPANY.TOLLFREE'); ?></a></li>
                        <li>
                            <a href="mailto:<?php echo Configure::read('COMPANY.SUPPORT_EMAIL'); ?>"><img src="<?php echo HTTP_ROOT; ?>images/mail.png" alt="mail" width="14" height="11"  /> <?php echo Configure::read('COMPANY.SUPPORT_EMAIL'); ?></a>
                        </li>
                    <?php }?>
                    <?php if ($this->Session->read('Auth.User.id') > 0) {?>
                    <li>					
                        <span class="prof_m_span">
                            <a class="anchor top-user-image" style="background:none" id="open_popup"><img src="<?php echo $this->Format->user_photo($this->Session->read('Auth.User'),40,40,1); ?>" alt="User" style=""/></a>
                            <div class="popup_profile_m">
                                <div class="arrow-top"><img src="<?php echo HTTP_ROOT; ?>images/form/profile_arrow.png" /></div>
                                <div class="others" style="background:#fafafa">How others see you as...</div>
                                <div class="cb"></div>
                                <div class="fl pro_pix">
                                    <a href="<?php echo HTTP_ROOT; ?>edit-profile" title="Change Image" style="border-bottom:none;padding: 0;">
                                        <img src="<?php echo $this->Format->user_photo($this->Session->read('Auth.User'),80,80); ?>" />
                                    </a>
                                </div>
                                <div class="fr pro_details">
                                    <div class="pro-name">
                                        <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'dashboard')) ?>" style="text-decoration:none;border-bottom:none;padding: 0;">
                                            <?php  echo $this->Session->read('Auth.User.name')?>
                                        </a>
										<div style="font-size:15px;color:#333;margin-top:10px;"><?php  echo $this->Session->read('Auth.User.email')?></div>
										<div style="font-size:15px;color:#333;margin-top:5px;"><?php  echo $this->Format->formatPhoneNumber($this->Session->read('Auth.User.phone'));?></div>
                                    </div>
                                </div>
                                <div class="cb"></div>
								<div class="signout">
									<div class="cb10"></div>
									<div class="" style="background:#fafafa;padding:15px;">
										<span class="grey-btn"><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'dashboard')); ?>" class="cmn_btn_n" style="border-bottom:none;">Go to Dashboard</a></span>
									</div>
									<div class="cb10"></div>
									<span class="grey-btn fl"><a href="<?php echo HTTP_ROOT; ?>edit-profile" style="border-bottom:none;">Edit Profile</a></span>
									<span class="grey-btn fr"><a href="<?php echo HTTP_ROOT; ?>logout" style="border-bottom:none;">Logout</a></span>
									<div class="cb"></div>
								</div>
                            </div>
                        </span>

                    </li>
                    <?php }?>
                </ul>

                <ul>
                    <?php if ($this->Session->read('Auth.User.id') > 0) { /*?>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'edit',$user['id'])) ?>">Edit Profile</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'logout')) ?>">Logout</a></li>
                        <?php */ } else { ?>
                        <li <?php if($parms['controller'] == 'users' && $parms['action'] == 'sign_up'){ echo 'class="active"';}?>>
                            <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'sign_up')) ?>">Sign Up</a>
                        </li>
                        <li class="btn_top"><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'login')) ?>">Sign In</a></li>
                    <?php } ?>
                </ul>
            </div>		
    </div>
</div>
<script type="text/javascript">
 $(document).ready(function(){
        $('.small-menu').click(function(){
            $(".m-screen-menu").slideToggle(500);
        }); 
    });
</script>