BusinessDetail = {
    flag:true,
    init:function(){
        $('.toggle-more-details').click(function(){
            if($('.business_more_details').is(":visible")){
                $('.business_more_details').slideUp();
                $('.toggle-more-details').html('More Details...');
            }else{
                $('.business_more_details').slideDown();
                $('.toggle-more-details').html('Less...');
            }
        });
        var tooltipvalues = ['bad', 'poor', 'ok', 'good', 'super'];
        $('#rateit9').rateit({step:0.5,backingfld:'#backingfld',starwidth:'20',})
                .on('beforerated', function (e, value) {$('#backingfld_span').html(value+' Star'+(parseInt(value)>1?"s":""));});
        
        $('#submit_review').click(function(){
            if(!BusinessDetail.flag){
                return false;
            }
            General.hideAlert('now');
            General.hideAlert();
            if(stats !== '1'){
                alert('Business is not active.','error');
                return false;
            }
            if($('#txt_review').val().trim() == ''){
                $('#txt_review').focus()
                alert('Please give your review to post.','error');
                return false;
            }
            if($('#backingfld').val() == ''){
                $('#backingfld').val(0);
            }
            var params = {
                rate:$('#backingfld').val(),
                review:escape($('#txt_review').val()),
                id:$(this).attr('data-bid'),
                ajax:1
            };
            if(BusinessDetail.flag){
                BusinessDetail.flag = false;
            }
            $('#submit_review').val('Loading...');
            $.ajax({
                url: HTTP_ROOT + "business_ratings/add",
                data: params,
                method: 'post',
                dataType: 'json',
                success: function(response) {
                    BusinessDetail.flag = true;
                    $('#submit_review').val('Post');
                    $('#txt_review').val('');
                    $('#rateit9').rateit('reset');
                    if(response.success === 1){
                        $('#backingfld_span').html('');
                        $(".review_count").html(parseInt($(".review_count").html())+1).parent().show();
                        $('.no_review_block').size()>0?$('.no_review_block').remove():'';
                        $.ajax({
                            url: HTTP_ROOT + "business_ratings/view/"+response.id,
                            data: {id:response.id},
                            method: 'post',
                            success: function(response) {
                                $('#review_box').append(response);
                            }
                        });
                    }
                    alert(response.message,(response.success === 1 ? "success" : "error"));
                }
            });
        });
        
        
        /*slider*/
        /*var options = {
            $AutoPlay: true, //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
            $AutoPlayInterval: 4000, //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
            $SlideDuration: 500, //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
            $DragOrientation: 3, //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
            $UISearchMode: 0, //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).

            $ThumbnailNavigatorOptions: {
                $Class: $JssorThumbnailNavigator$, //[Required] Class to create thumbnail navigator instance
                $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always

                $Loop: 0, //[Optional] Enable loop(circular) of carousel or not, 0: stop, 1: loop, 2 rewind, default value is 1
                $SpacingX: 3, //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                $SpacingY: 3, //[Optional] Vertical space between each thumbnail in pixel, default value is 0
                $DisplayPieces: 5, //[Optional] Number of pieces to display, default value is 1
                $ParkingPosition: 50, //[Optional] The offset position to park thumbnail,

                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$, //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 2, //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 6                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            }
        };
        if($('#slider1_container').find('.jssort07').length >0){
            var jssor_slider1 = new $JssorSlider$("slider1_container", options);
       
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$ScaleWidth(Math.min(parentWidth, 510));
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
         }*/
    }
};
jQuery(document).ready(function() {
    BusinessDetail.init();
});
