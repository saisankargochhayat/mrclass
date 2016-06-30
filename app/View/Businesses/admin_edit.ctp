<?php
echo $this->Html->css(array('bootstrap-tagsinput', 'select2.min', 'bootstrap-datepicker.min'), array('block' => 'bootstrap_datatable_css'));
echo $this->Html->script(array('bootstrap-datepicker.min', 'select2.full.min', 'bootstrap-tagsinput.min'), array('block' => 'demojs'));
echo $this->Html->script('business_add', array('inline' => false));
?>
<section class="content-header">
    <h1><?php echo __('Edit Business : ' . $this->request->data['Business']['name']); ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $this->Html->url(array('controller' => 'businesses', 'action' => 'index', 'admin' => 1)); ?>">Businesses</a></li>
        <li class="active"><?php echo __('Edit Business'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <?php echo $this->element('admin_business_edit_tabs'); ?>
                <div class="tab-content">
                    <?php echo $this->Form->create('Business', array('id' => 'BusinessEditForm', 'class' => 'form-horizontal', 'autocomplete' => 'off', 'type' => 'file')); ?>
                    <?php echo $this->Form->input('id'); ?>
                    <?php if ($this->params['pass'][1] == 'info') { ?>
                    <div class="active tab-pane" id="businessEdit">
                        <div class="box">
                            <div class="box-header with-border">
                                <i class="ion ion-briefcase"></i>
                                <h3 class="box-title"><?php echo __('Add basic business information'); ?></h3>
                            </div><!-- /.box-header -->
                            <div class="box-body ">
                                <div class="form-group">
                                    <label for="BusinessName" class="col-sm-2 control-label"><?php echo __('Name'); ?>*</label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('name', array('label' => false, 'div' => false, 'placeholder' => 'Name', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label"><?php echo __('User'); ?> *</label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('user_id', array('options' => $users, 'label' => false, 'div' => false, 'empty' => __('Select User'), 'class' => 'form-control select2', 'selected' => $this->request->data['Business']['user_id'])); ?>
                                        <div class="error" id="BusinessUserIdErr"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="BusinessType" class="col-sm-2 control-label"><?php echo __('Business Type'); ?>*</label>
                                    <div class="col-sm-10">
                                        <div class="radio fl">
                                            <label><input name="data[Business][type]" id="BusinessType1" value="group" <?php echo ($this->request->data['Business']['type'] != 'private') ? 'checked' : ''; ?> type="radio"/>&nbsp;Group</label>
                                        </div>
                                        <div class="radio fl" style="margin-left:20px;">
                                            <label><input name="data[Business][type]" id="BusinessType2" value="private" <?php echo ($this->request->data['Business']['type'] == 'private') ? 'checked' : ''; ?> type="radio"/>&nbsp;Private</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="BusinessCategoryId" class="col-sm-2 control-label"><?php echo __('Category'); ?>&nbsp;<i class="fa fa-info-circle" rel="tooltip" title="You can select multiple categories"></i></label>
                                    <div class="col-sm-10">
                                    	<?php echo $this->Form->input('category_id', array('options' => $pcategories, 'multiple' => true, 'data-placeholder' => __('Select Category'), 'label' => false, 'div' => false, 'class' => 'form-control select2')); ?>
                                    </div>
                                </div>
                                    <?php /* ?><div class="form-group">
                                        <label for="BusinessSubcategoryId" class="col-sm-2 control-label"><?php echo __('Sub Category'); ?>
                                        <i class="fa fa-info-circle" rel="tooltip" title="You can select multiple sub categories"></i></label>
                                        <div class="col-sm-10">
                                            <?php
                                            echo $this->Form->input('subcategory_id_tmp', array('type' => "hidden", "id" => "BusinessSubcategoryId_tmp", "value" => implode(',', $this->data['Business']['subcategory_id'])));
                                            echo $this->Form->input('subcategory_id', array('options' => array(), 'data-placeholder' => __('Select Sub Category'), 'label' => false, 'div' => false, 'class' => 'form-control select2', 'multiple' => "multiple", 'value' => ''));
                                            ?>
                                        </div>
                                    </div><?php */ ?>
                                <div class="form-group">
                                    <label for="BusinessKeyword" class="col-sm-2 control-label"><?php echo __('Keywords'); ?>
                                        <i class="fa fa-info-circle" rel="tooltip" title="You can enter multiple keywords. Press Enter to insert new keyword"></i></label>
                                    <div class="col-sm-10">
                                            <?php echo $this->Form->input('keyword', array('label' => false, 'div' => false, 'class' => 'form-control', "placeholder" => __("Keyword"))); ?>
                                    </div>
                                    <div class="col-sm-10 fr" id="BusinessKeywordErr"></div>
                                </div>
                                <div class="form-group">
                                    <label for="BusinessMinAgeGroup" class="col-sm-2 control-label"><?php echo __('Age Group'); ?></label>
                                    <div class="col-sm-4">
                                            <?php echo $this->Form->input('min_age_group', array('options' => range(0, 99), 'label' => false, 'div' => false, 'placeholder' => 'Min age', 'class' => 'form-control select2')); ?>
                                        <div class="error" id="BusinessMinAgeGroupErr"></div>
                                    </div>
                                    <div class="col-sm-1" style="text-align:center;"> to </div>
                                    <div class="col-sm-5">
                                            <?php echo $this->Form->input('max_age_group', array('options' => range(0, 99), 'label' => false, 'div' => false, 'placeholder' => 'Max age', 'class' => 'form-control select2')); ?>
                                        <div class="error" id="BusinessMaxAgeGroupErr"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo __('Student:Teacher Ratio'); ?></label>
                                    <div class="col-sm-4">
                                <?php echo $this->Form->input('student_ratio', array('type' => 'text', 'class' => 'form-control numbersOnly', 'placeholder' => 'Student', 'div' => false, 'label' => false)); ?>
                                        <span id="student_ratio_error"></span>
                                    </div>
                                    <div class="col-sm-1" style="text-align:center;font-weight: bold;font-size: 20px;"> : </div>
                                    <div class="col-sm-5">
                               <?php echo $this->Form->input('teacher_ratio', array('type' => 'text', 'class' => 'form-control numbersOnly', 'placeholder' => 'Teacher', 'div' => false, 'label' => false)); ?>
                                        <span id="teacher_ratio_error"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="BusinessGender" class="col-sm-2 control-label"><?php echo __('Targeted Gender'); ?></label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('gender', array('options' => array('both' => 'Both (Male & Female)', 'male' => 'Male', 'female' => 'Female'), 'data-placeholder' => __('Choose Gender'), 'label' => false, 'div' => false, 'class' => 'form-control select2')); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="BusinessPrice" class="col-sm-2 control-label"><?php echo __('Price'); ?>*</label>
                                    <div class="col-sm-4">
                                            <?php echo $this->Form->input('price', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => 'Min Price', 'class' => 'form-control')); ?>
                                        <div class="error" id="BusinessPriceErr"></div>
                                    </div>
                                    <div class="col-sm-1" style="text-align:center;"> to </div>
                                    <div class="col-sm-5">
                                            <?php 
                                            $max_price = floatval($this->data['Business']['max_price']) > 0 ? $this->data['Business']['max_price'] : "";
                                            echo $this->Form->input('max_price', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => 'Max Price', 'class' => 'form-control', 'value' => $max_price)); 
                                            ?>
                                        <div class="error" id="BusinessMaxPriceErr"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="BusinessFacilities" class="col-sm-2 control-label"><?php echo __('Facilities'); ?>
                                    <i class="fa fa-info-circle" rel="tooltip" title="You can select multiple facilities"></i></label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('facilities', array('options' => $facilities, 'multiple' => true, 'label' => false, 'div' => false, 'data-placeholder' => 'Select Facilities', 'class' => 'form-control select2')); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="BusinessAboutUs" class="col-sm-2 control-label"><?php echo __('About Us'); ?></label>
                                    <div class="col-sm-10">
                                            <?php echo $this->Form->input('about_us', array('type' => 'textarea', 'label' => false, 'div' => false, 'placeholder' => 'About us', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="BusinessLogo" class="col-sm-2 control-label"><?php echo __('Logo'); ?></label>
                                    <div class="col-sm-10">
                                        <?php 
                                            $found = '';
                                            $file_path = BUSINESS_LOGO_DIR . "logo" . DS . $this->data['Business']['id'] . DS . $this->data['Business']['logo'];
                                            if (trim($this->data['Business']['logo']) != '' && file_exists($file_path)) {
                                                $found = 'Yes';
                                                ?>
                                                <input type="hidden" id="logo_old" value="<?php echo trim($this->data['Business']['logo']); ?>"/>
                                                <div class="logo_image">
                                                    <img class="colorbox" src="<?php echo $this->Format->show_business_logo($this->data, 122, 122, 0); ?>" 
                                                         data-href="<?php echo $this->Format->show_business_logo($this->data, 500, 500, 0); ?>" alt=""/>
                                                    <a class="anchor" onclick="$('.logo_image').slideUp();$('.logo_edit').slideDown();">Change Logo</a>
                                                    &nbsp;|&nbsp;
                                                    <a class="anchor" onclick="delete_logo(<?php echo intval($this->data['Business']['id']); ?>)">Remove Logo</a>
                                                </div>
                                        <?php } ?>
                                        <div class="logo_edit <?php echo $found == 'Yes' ? "none" : ""; ?>">
                                                <?php echo $this->Form->input('logo', array('type' => 'file', 'label' => false, 'div' => false, 'placeholder' => 'Logo', 'class' => 'form-control')); ?>
                                                <?php if ($found == 'Yes') { ?>
                                                    <div class="cb"></div>
                                                    <a class="anchor cancelicn" style="margin-bottom:10px;" onclick="$('.logo_edit').slideUp();$('.logo_image').slideDown();">Cancel</a>
                                                <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                    <div class="checkbox">
                                        <label class="col-sm-10 col-sm-offset-2" for="discount_allowed">
                                            <input type="checkbox" name="data[Business][discount_allowed]" id="discount_allowed" value="yes" <?php echo $this->data['Business']['discount_allowed']=='yes'?"checked='checked'":"";?>/> Give discount on bookings?
                                        </label>
                                        <div class="clear">&nbsp;</div>
                                    </div>
                                    <div class="form-group discount_allowed_blk" style="display:none;">
                                        <label for="BusinessLogo" class="col-sm-2 control-label"><?php echo __('Discount Details'); ?> </label>
                                        <div class="col-sm-5">
                                            <?php echo $this->Form->input('discount_amount', array('type' => 'number', 'label' => false, 'div' => false, 'placeholder' => __('Discount Amount'), 'class' => 'form-control')); ?>
                                        </div>
                                        <div class="col-sm-5">
                                            <?php $discount_arr = array('flat' => 'Flat', 'percentage' => 'Percentage'); ?>
                                            <?php echo $this->Form->input('discount_type', array('options' => $discount_arr, 'empty' => __('Discount Type'), 'label' => false, 'div' => false, 'class' => 'form-control select2')); ?>
                                        </div>
                                    </div>
                                <div class="private_business" <?php echo ($this->request->data['Business']['type'] != 'private') ? 'style="display:none;"' : ''; ?>>
                                    <hr/>
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><?php echo __('Private Business Details'); ?></h3>
                                    </div><!-- /.box-header -->
                                    <div class="form-group">
                                        <label for="BusinessDob" class="col-sm-2 control-label"><?php echo __('Date Of Birth'); ?></label>
                                        <div class="col-sm-10">
                                                <?php echo $this->Form->input('dob', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Date Of Birth'), 'class' => 'form-control datepicker', 'value' => $this->Format->dateFormat($this->data['Business']['dob']))); ?>
                                        </div>
                                    </div>
                                        <?php /* ?><div class="form-group">
                                            <label for="BusinessEstablished" class="col-sm-2 control-label"><?php echo __('Date of Establishment'); ?></label>
                                            <div class="col-sm-10">
                                                <?php echo $this->Form->input('established', array('type' => 'text', 'label' => false, 
                                                    'div' => false, 'placeholder' => __('Date of Establishment'), 'class' => 'form-control datepicker',
                                                    'value' => $this->Format->dateFormat($this->data['Business']['established'])));
                                                ?>
                                            </div>
                                        </div><?php */ ?>
                                    <div class="form-group">
                                        <label for="BusinessEducation" class="col-sm-2 control-label"><?php echo __('Education'); ?>*</label>
                                        <div class="col-sm-10">
                                                <?php echo $this->Form->input('education', array('label' => false, 'div' => false, 'placeholder' => __('Education'), 'class' => 'form-control')); ?>
                                        </div>
                                    </div>
                                        <?php /* ?><div class="form-group">
                                            <label for="BusinessTagline" class="col-sm-2 control-label"><?php echo __('Tag Line'); ?>*</label>
                                            <div class="col-sm-10">
                                                <?php echo $this->Form->input('tagline', array('label' => false, 'div' => false, 'placeholder' => __('Tag Line'), 'class' => 'form-control')); ?>
                                            </div>
                                        </div><?php */ ?>
                                    <div class="form-group">
                                        <label for="BusinessExperience" class="col-sm-2 control-label"><?php echo __('Experience'); ?>*</label>
                                        <div class="col-sm-10">
                                                <?php echo $this->Form->input('experience', array('type' => 'textarea', 'label' => false, 'div' => false, 'placeholder' => __('Experience'), 'class' => 'form-control')); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="BusinessName" class="col-sm-2 control-label"><?php echo __('Languages'); ?>*</label>
                                        <div class="col-sm-10">
                                                <?php echo $this->Form->input('languages', array('options' => $languages, 'label' => false, 'div' => false, 'data-placeholder' => __('Select Languages'), 'class' => 'form-control select2', 'multiple' => 'multiple')); ?>
                                            <div class="error" id="BusinessLanguagesErr"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="BusinessPreferredLocation" class="col-sm-2 control-label"><?php echo __('Preffered Location'); ?>*</label>
                                        <div class="col-sm-10">
                                            <div class="radio fl">
                                                <label><input name="data[Business][preferred_location]" id="BusinessPreferredLocation1" value="own" 
                                                                      <?php echo ($this->request->data['Business']['preferred_location'] != 'customer') ? 'checked' : ''; ?> type="radio"/>
                                                    &nbsp;Own Place</label>
                                            </div>
                                            <div class="radio fl" style="margin-left:20px;">
                                                <label><input name="data[Business][preferred_location]" id="BusinessPreferredLocation2" value="customer" 
                                                                      <?php echo ($this->request->data['Business']['preferred_location'] == 'customer') ? 'checked' : ''; ?> type="radio"/>
                                                    &nbsp;Customer Place</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="BusinessFreeDemoClass" class="col-sm-2 control-label"><?php echo __('Free Demo Class'); ?>*</label>
                                        <div class="col-sm-10">
                                            <div class="radio fl">
                                                <label><input name="data[Business][free_demo_class]" id="BusinessFreeDemoClass1" value="yes" 
                                                        <?php echo ($this->request->data['Business']['free_demo_class'] != 'no') ? 'checked' : ''; ?> type="radio"/>
                                                    &nbsp;Yes</label>
                                            </div>
                                            <div class="radio fl" style="margin-left:20px;">
                                                <label><input name="data[Business][free_demo_class]" id="BusinessFreeDemoClass2" value="no" 
                                                        <?php echo ($this->request->data['Business']['free_demo_class'] == 'no') ? 'checked' : ''; ?> type="radio"/>
                                                    &nbsp;No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.tab-pane -->

                    <?php } elseif ($this->params['pass'][1] == 'venue') { ?>
                    <div class="active tab-pane" id="venue">
                        <div class="box">
                            <div class="box-header with-border">
                                <i class="ion ion-ios-location"></i>
                                <h3 class="box-title"><?php echo __('Add location information'); ?></h3>
                            </div><!-- /.box-header -->
                            <div class="box-body ">
                                <div class="form-group">
                                    <label for="BusinessCityId" class="col-sm-2 control-label"><?php echo __('City'); ?></label>
                                    <div class="col-sm-10">
                                            <?php echo $this->Form->input('city_id', array('options' => $cities, 'data-placeholder' => __('-- Choose City --'), 'label' => false, 'div' => false, 'class' => 'form-control select2')); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="BusinessLocalityId" class="col-sm-2 control-label"><?php echo __('Locality'); ?></label>
                                    <div class="col-sm-10">
                                            <?php
                                            echo $this->Form->input('locality_id_tmp', array('type' => "hidden", "id" => "BusinessLocalityId_tmp", "value" => @$this->data['Business']['locality_id']));
                                            echo $this->Form->input('locality_id', array('options' => array(), 'data-placeholder' => __('Choose Locality'), 'label' => false, 'div' => false, 'class' => 'form-control select2'));
                                            ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="BusinessAddress" class="col-sm-2 control-label"><?php echo __('Address'); ?>*</label>
                                    <div class="col-sm-10">
                                            <?php echo $this->Form->input('address', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => 'Address', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="BusinessLandmark" class="col-sm-2 control-label"><?php echo __('Landmark'); ?></label>
                                    <div class="col-sm-10">
                                            <?php echo $this->Form->input('landmark', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => 'Landmark', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="BusinessPincode" class="col-sm-2 control-label"><?php echo __('Pincode'); ?>*</label>
                                    <div class="col-sm-10">
                                            <?php echo $this->Form->input('pincode', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Pincode'), 'class' => 'form-control numbersOnly', 'maxlength' => 6)); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label"><?php echo __('Map'); ?></label>
                                        <?php
                                        echo $this->Form->input('latitude', array('id' => 'latitude', 'type' => "hidden",));
                                        echo $this->Form->input('longitude', array('id' => 'longitude', 'type' => "hidden",));
                                        ?>
                                    <div class="col-sm-10">
                                        <div  id="map" style="height:350px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.tab-pane -->
                    <?php } else if ($this->params['pass'][1] == 'contact') { ?>
                    <div class="active tab-pane" id="contact">
                        <div class="box">
                            <div class="box-header with-border">
                                <i class="ion ion-android-contact"></i>
                                <h3 class="box-title"><?php echo __('Add contact information'); ?></h3>
                            </div><!-- /.box-header -->
                            <div class="box-body ">
                                <div class="form-group">
                                    <label for="BusinessContactPerson" class="col-sm-2 control-label"><?php echo __('Contact Person'); ?>*</label>
                                    <div class="col-sm-10">
                                            <?php echo $this->Form->input('contact_person', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => 'Contact Person', 'class' => 'form-control alphaOnly')); ?>
                                    </div>
                                </div>
                                <div class="form-group" id="BusinessPhoneBlock">
                                    <label for="BusinessPhone" class="col-sm-2 control-label"><?php echo __('Phone'); ?>*
                                        <i class="fa fa-info-circle" rel="tooltip" title="You can select multiple phone numbers"></i></label>
                                    <div class="col-sm-10">
                                        <input name="data[Business][phone]" placeholder="Phone" class="form-control" type="text" id="BusinessPhone" required="required">
                                        <div class="cb"></div>
                                        <div class="error" id="BusinessPhoneErr"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="BusinessEmail" class="col-sm-2 control-label"><?php echo __('Email'); ?>*</label>
                                    <div class="col-sm-10">
                                            <?php echo $this->Form->input('email', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => 'Email', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="BusinessWebsite" class="col-sm-2 control-label"><?php echo __('Website'); ?></label>
                                    <div class="col-sm-10">
                                            <?php echo $this->Form->input('website', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => 'Website', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                               <?php if ((isset($subscription['Subscription']['social_media_widget']) && intval($subscription['Subscription']['social_media_widget'])) || (empty($subscription))) { ?>
                                <div class="form-group">
                                    <label for="BusinessFacebook" class="col-sm-2 control-label"><?php echo __('Facebook'); ?></label>
                                    <div class="col-sm-10">
                                            <?php echo $this->Form->input('facebook', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => 'Facebook', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="BusinessTwitter" class="col-sm-2 control-label"><?php echo __('Twitter'); ?></label>
                                    <div class="col-sm-10">
                                                <?php echo $this->Form->input('twitter', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => 'Twitter', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="BusinessGplus" class="col-sm-2 control-label"><?php echo __('Google'); ?><sup>+</sup></label>
                                    <div class="col-sm-10">
                                                <?php echo $this->Form->input('gplus', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => 'Google Plus', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="BusinessYoutube" class="col-sm-2 control-label"><?php echo __('Youtube'); ?></label>
                                    <div class="col-sm-10">
                                                <?php echo $this->Form->input('youtube', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => 'Youtube', 'class' => 'form-control')); ?>
                                    </div>
                                </div>
                               <?php } ?>
                            </div>
                        </div>
                    </div><!-- /.tab-pane -->
                        <?php } ?>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-success" onclick="admin_edit_business_valid();"><?php echo __('Submit'); ?></button>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->

<script type="text/javascript">
    $(document).ready(function() {});
    function delete_logo(id){
        if (confirm('Are you sure you want to delete logo?')) {
            $.post(HTTP_ROOT + "businesses/delete_logo", {id: id}, function(response) {
                if (response.success == 1) {
                    $('.logo_image').slideUp().remove();
                    $('.cancelicn').remove();
                    $('.logo_edit').slideDown();
                }
                alert(response.message);
            }, 'json');
        }
    }
</script>
<?php if ($this->params['pass'][1] == 'info') { ?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#BusinessKeyword").tagsinput({confirmKeys: [13, 44], trimValue: true});
        <?php if (trim($this->data['BusinessKeyword']) != "") { ?>
        var keywordArr = "<?php echo $this->data['BusinessKeyword']; ?>".split(',');
        if (keywordArr.length > 0) {
            $.each(keywordArr, function(e, v) {
                $('#BusinessKeyword').tagsinput('add', trim(v));
            })
        }
        <?php } ?>
    });
</script>
<?php } ?>
<?php if ($this->params['pass'][1] == 'venue') { ?>
<script type="text/javascript">    var map;
    var markers = [];
    var data_arr = [];
    var geocoder;
    var map;
    $(document).ready(function($){});

    function initMap() {
        var myloc = {
            lat: parseFloat($('#latitude').val()),
            lng: parseFloat($('#longitude').val())
        };
        //console.log(myloc)
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            scrollwheel: false,
            center: myloc
        });
        geocoder = new google.maps.Geocoder();

        var marker = new google.maps.Marker({
            map: map,
            draggable: true,
            position: myloc
        });
        marker.addListener('click', function() {
            infoWindow.open(map, marker);
        });
        markers.push(marker);
        google.maps.event.addListener(marker, 'dragend', function(evt) {
            set_latlng(evt.latLng.lat().toFixed(7), evt.latLng.lng().toFixed(7));
            geocodePosition(marker.getPosition());
        });
        //#BusinessLocalityId
        //,#BusinessPincode
        setTimeout(function() {
            $("#BusinessCityId,#BusinessAddress,#BusinessLandmark").change(function() {
                Business.geo_search(geocoder, map);
            });
        }, 1000);
    }

    function geocodeAddress(geocoder, resultsMap, address) {
        //var address = document.getElementById('address').value;
        geocoder.geocode({
            'address': address
        }, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                setMapOnAll(null);
                resultsMap.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: resultsMap,
                    draggable: true,
                    position: results[0].geometry.location
                });
                google.maps.event.addListener(marker, 'dragend', function(evt) {
                    set_latlng(evt.latLng.lat().toFixed(7), evt.latLng.lng().toFixed(7));
                    geocodePosition(marker.getPosition());
                });
                markers.push(marker);
                console.log(results[0].formatted_address);
                Business.set_address(results[0].formatted_address);
                //console.log(results[0].geometry.location.lat());console.log(results[0].geometry.location.lng());
                $('#latitude').val(results[0].geometry.location.lat());
                $('#longitude').val(results[0].geometry.location.lng());
            } else {
                console.log('Geocode was not successful for the following reason: ' + status);
            }
        });
    }

    function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
        markers = [];
    }

    function geocodePosition(pos) {
        geocoder = new google.maps.Geocoder();
        geocoder.geocode({latLng: pos},
        function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                //console.log(results[0].geometry.location.lat())
                //console.log(results[0].geometry.location.lng())
                //$('#latitude').val(results[0].geometry.location.lat());
                //$('#longitude').val(results[0].geometry.location.lng());
                //console.log(results[0].formatted_address);
                Business.set_address(results[0].formatted_address);
                //$("#mapSearchInput").val(results[0].formatted_address);
                //$("#mapErrorMsg").hide(100);
            } else {
                console.log('Cannot determine address at this location.' + status);
                //$("#mapErrorMsg").html('Cannot determine address at this location.'+status).show(100);
            }
        });
    }
    function set_latlng(lat, lng) {
        $('#latitude').val(lat);
        $('#longitude').val(lng);
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_KEY; ?>&libraries=places&callback=initMap" async defer></script>
<?php } ?>
<?php if ($this->params['pass'][1] == 'contact') { ?>
<script type="text/javascript">
    $(document).ready(function($) {
        $("#BusinessPhone").tagsinput({maxTags: 15, maxChars: 20, confirmKeys: [13, 44], trimValue: true});
        $('#BusinessPhone').on('beforeItemAdd', function(event) {
            var isnum = /^(?=.*[0-9])[-+()0-9]+$/.test(event.item);
            if (!isnum) {
                alert("Only Numeric Inputs allowed", "error");
                event.cancel = true;
            }
            if (/^[0-9]{1,8}$/.test(+event.item) && event.item.length < 8) {
                alert("Phone numbers must be greater than 8 characters.", "error");
                event.cancel = true;
            }
        });
        $.ajax({
            url: HTTP_ROOT + "businesses/get_phone",
            type: 'POST',
            dataType: 'json',
            data: {
                id: $('#BusinessId').val()
            },
            success: function(res) {
                if (trim(res.Business.phone) !== "") {
                    var phone_Arr = res.Business.phone.split(',');
                    if (phone_Arr.length > 0) {
                        for (var i = 0; i < phone_Arr.length; i++) {
                            $('#BusinessPhone').tagsinput('add', trim(phone_Arr[i]));
                        }
                    }
                }
            }
        });
        if ($('#BusinessPhoneBlock').find('.bootstrap-tagsinput').is(':visible')) {
            $('#BusinessPhoneBlock').find('.bootstrap-tagsinput').attr('rel', 'tooltip').tooltip({title: '<i class="fa fa-info-circle" style="color:#fff"></i>  Enter phone numbers separated by a comma (,) . Only numbers and following characters are allowed.<br/>+ , - , ( , )', animation: true, html: true});
        }
    });
</script>
<?php } ?>