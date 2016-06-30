<link href="<?php echo HTTP_ROOT; ?>css/effect.css" rel="stylesheet" />
<?php echo $this->Html->script('jquery.lazyload.min', array('block' => 'lazyLoad')); ?>
<?php echo $this->Html->script('event', array('inline' => false)); ?>
<style type="text/css">
    #map{height: 75px; background-image: none; }
    .map-x{ position: absolute; left:46%; top:0px;}
    .map-x a.togglemap{background: #014D99; color: #fff; text-align: center; padding-top: 4px; border-radius: 25%; height: 24px; width: 35px;position:relative}
    .togglemap i{display: block; font-size: 15px;}
    .text-f-map{font-size: 13px;left: 50%;margin-left: -137px;position: absolute;top: 2px;}
    .time_list.age_grp div select{width: 32%;}
    .ui-autocomplete-loading {background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;}
    .srh_list_mc .rt_det_mc{width:100%; margin-top:25px; float:left; display: inline-block;}
    @media only screen and (max-width:420px){
        #map{ overflow: hidden!important;width:360px !important; }
        .srh_list_mc .rt_det_mc .top_sch_map .srch_frm_list {left: 37px;}
    }
    @media only screen and (max-width:340px){
        #map{width:309px !important;}
        .srh_list_mc .rt_det_mc .top_sch_map .srch_frm_list {left: 10px;}
    }
</style>

<div class="srh_list_mc">
    <div class="wrapper">
        <div class="fl rt_det_mc relative">
            <div class="list_det_cnt searchresultsummary" style="visibility: visible;">
                <div class="switch_list_icn relative" style="margin-bottom: 0px;">					
                    <span class="fl" style="font-size:18px; color: #333;" id="search_result_count_message">0 Events found</span>
                    <?php /* <a class="grid_view viewblockstoggle anchor active" data-view="grid"></a>
                      <a class="list_view viewblockstoggle anchor" data-view="list"></a> */ ?>
                </div>
            </div>
            <div class="cb"></div>
            <div class="relative" style="background: #fff; min-height: 410px;margin-top:20px;">
                <div id="content_box" class="list_det_cnt viewblocks gridviewblock" style="padding-top:0px;">
                    <?php #echo $this->element('../content/ajax_event_list'); ?>
                </div>
                <div id="content_loader" class="pageloader none" style="display: none;"><center>Loading...</center></div>
            </div>
        </div>
        <div class="cb"></div>
    </div>
</div>

<script>
    var EVENT_SEARCH_PAGE_LIMIT = <?php echo BUSINESS_SEARCH_PAGE_LIMIT; ?>;
    $(document).ready(function () {

    });
</script>
