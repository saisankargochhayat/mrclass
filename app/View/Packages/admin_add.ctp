<section class="content-header">
    <h1><?php echo __('Add Package'); ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo $this->Html->url($adminpanel_dashboard_link);?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="<?php echo $this->Html->url(array('controller'=>'packages','action'=>'index','admin'=>1));?>"><?php echo __('Packages'); ?></a></li>
        <li><?php echo __('Add Package'); ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#packageAdd" data-toggle="tab"><?php echo __('Add Package'); ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="packageAdd">
                  <?php echo $this->Form->create('Package',array('action'=>'add','class'=>'form-horizontal','autocomplete' => 'off')); ?>
                        <div class="form-group">
                            <label for="PackageName" class="col-sm-2 control-label"><?php echo __('Name'); ?>*</label>
                            <div class="col-sm-10">
                          <?php echo $this->Form->input('name',array('label'=>false,'div'=>false,'placeholder'=>'Name','class'=>'form-control alphaOnly'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PackagePrice" class="col-sm-2 control-label"><?php echo __('Price'); ?>*</label>
                            <div class="col-sm-10">
                          <?php echo $this->Form->input('price',array('label'=>false,'div'=>false,'placeholder'=>'Price','class'=>'form-control numbersOnly'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PackagePrioritySearch" class="col-sm-2 control-label"><?php echo __('Priority Search'); ?>*</label>
                            <div class="col-sm-10" style="padding-top:8px;">
                                <div class="col-xs-1">
                                <input name="data[Package][priority_search]" id="PackagePriority_" value="" type="hidden" />
                                <label for="UserGenderY">
                                    <input name="data[Package][priority_search]" id="PackagePriorityY" value="1" type="radio" />&nbsp;&nbsp;Yes
                                </label>
                                </div>
                                <div class="col-xs-1">
                                <label for="PackagePriorityN">
                                    <input name="data[Package][priority_search]" id="PackagePriorityN" value="0" type="radio" />&nbsp;&nbsp;No
                                </label> 
                                </div>
                                <div class="clearfix"></div>
                            <div class="error" id="priority_seacrh_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PackagePersonalSubdomain" class="col-sm-2 control-label"><?php echo __('Personal sub-domain'); ?>*</label>
                            <div class="col-sm-10" style="padding-top:8px;">
                                <div class="col-xs-1">
                                <input name="data[Package][personal_subdomain]" id="PackagePersonalSubdomain_" value="" type="hidden" />
                                <label for="UserGenderY">
                                    <input name="data[Package][personal_subdomain]" id="PackagePersonalSubdomainY" value="1" type="radio" />&nbsp;&nbsp;Yes
                                </label>
                                </div>
                                <div class="col-xs-1">
                                <label for="PackagePriorityN">
                                    <input name="data[Package][personal_subdomain]" id="PackagePersonalSubdomainN" value="0" type="radio" />&nbsp;&nbsp;No
                                </label> 
                                </div>
                                <div class="clearfix"></div>
                            <div class="error" id="personal_sub_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PackageSocialMediaWidget" class="col-sm-2 control-label"><?php echo __('Social Media Widget'); ?>*</label>
                             <div class="col-sm-10" style="padding-top:8px;">
                                <div class="col-xs-1">
                                 <input name="data[Package][social_media_widget]" id="PackageSocialMediaWidget_" value="" type="hidden" />
                                <label for="UserGenderY">
                                    <input name="data[Package][social_media_widget]" id="PackageSocialMediaWidgetY" value="1" type="radio" />&nbsp;&nbsp;Yes
                                </label>
                                 </div>
                                 <div class="col-xs-1">
                                <label for="PackagePriorityN">
                                    <input name="data[Package][social_media_widget]" id="PackageSocialMediaWidgetN" value="0" type="radio" />&nbsp;&nbsp;No
                                </label> 
                                 </div>
                                 <div class="clearfix"></div>
                            <div class="error" id="social_media_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PackageMapIntegration" class="col-sm-2 control-label"><?php echo __('Google Map integration'); ?>*</label>
                            <div class="col-sm-10" style="padding-top:8px;">
                                <div class="col-xs-1">
                                <input name="data[Package][map_integration]" id="PackageMapIntegration_" value="" type="hidden" />
                                <label for="UserGenderY">
                                    <input name="data[Package][map_integration]" id="PackageMapIntegrationY" value="1" type="radio" />&nbsp;&nbsp;Yes
                                </label>
                                </div>
                                <div class="col-xs-1">
                                <label for="PackagePriorityN">
                                    <input name="data[Package][map_integration]" id="PackageMapIntegrationN" value="0" type="radio" />&nbsp;&nbsp;No
                                </label>
                                </div>
                                <div class="clearfix"></div>
                            <div class="error" id="map_integration_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PackagePhotoLimit" class="col-sm-2 control-label"><?php echo __('Photos Upload Limit'); ?>*</label>
                            <div class="col-sm-10">
                          <?php echo $this->Form->input('photo_limit',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'Photos Upload Limit','class'=>'form-control'));?>
                            </div>
                        </div><div class="form-group">
                            <label for="PackageVideoLimit" class="col-sm-2 control-label"><?php echo __('Videos Upload Limit'); ?>*</label>
                            <div class="col-sm-10">
                          <?php echo $this->Form->input('video_limit',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'Videos Upload Limit','class'=>'form-control'));?>
                            </div>
                        </div><div class="form-group">
                            <label for="PackageSubscription" class="col-sm-2 control-label"><?php echo __('Subscriptions'); ?>*</label>
                            <div class="col-sm-10">
                          <?php echo $this->Form->input('subscription',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'Subscriptions','class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PackageListingPeriod" class="col-sm-2 control-label"><?php echo __('Listing Period'); ?>*</label>
                            <div class="col-sm-10">
                          <?php echo $this->Form->input('listing_period',array('label'=>false,'div'=>false,'placeholder'=>'Listing Period','class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PackagePaymentMethod" class="col-sm-2 control-label"><?php echo __('Payment method'); ?>*</label>
                            <div class="col-sm-10">
                          <?php echo $this->Form->input('payment_method',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'Payment method','class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PackageEnquiries" class="col-sm-2 control-label"><?php echo __('Enquiries submission'); ?>*</label>
                            <div class="col-sm-10">
                          <?php echo $this->Form->input('enquiries',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'Enquiries submission','class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PackageAddressDetail" class="col-sm-2 control-label"><?php echo __('Address details'); ?>*</label>
                            <div class="col-sm-10" style="padding-top:8px;">
                                <div class="col-xs-1">
                                <input name="data[Package][address_detail]" id="PackageAddressDetail_" value="" type="hidden" />
                                <label for="UserGenderY">
                                    <input name="data[Package][address_detail]" id="PackageAddressDetailY" value="1" type="radio" />&nbsp;&nbsp;Yes
                                </label>
                                </div>
                                <div class="col-xs-1">
                                <label for="PackagePriorityN">
                                    <input name="data[Package][address_detail]" id="PackageAddressDetailN" value="0" type="radio" />&nbsp;&nbsp;No
                                </label>
                                </div>
                                <div class="clearfix"></div>
                            <div class="error" id="address_detail_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PackageCallRequest" class="col-sm-2 control-label"><?php echo __('Request a Call'); ?>*</label>
                            <div class="col-sm-10" style="padding-top:8px;">
                                <div class="col-xs-1">
                                <input name="data[Package][call_request]" id="PackageCallRequest_" value="" type="hidden" />
                                <label for="UserGenderY">
                                    <input name="data[Package][call_request]" id="PackageCallRequestY" value="1" type="radio" />&nbsp;&nbsp;Yes
                                </label>
                                </div>
                                <div class="col-xs-1">
                                <label for="PackagePriorityN">
                                    <input name="data[Package][call_request]" id="PackageCallRequestN" value="0" type="radio" />&nbsp;&nbsp;No
                                </label>
                                </div>
                                <div class="clearfix"></div>
                            <div class="error" id="call_request_error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PackageReview" class="col-sm-2 control-label"><?php echo __('Reviews'); ?>*</label>
                            <div class="col-sm-10">
                          <?php echo $this->Form->input('review',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'Reviews','class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="PackageFaq" class="col-sm-2 control-label"><?php echo __('FAQs'); ?>*</label>
                            <div class="col-sm-10">
                          <?php echo $this->Form->input('faq',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'FAQs','class'=>'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" onclick="return validate_admin_package_add();" class="btn btn-success"><?php echo __('Submit'); ?></button>
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