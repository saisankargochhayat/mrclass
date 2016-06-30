Event = {
    page: '1', hash: '',
    init: function () {
        $('.colorbox').colorbox();
        /*hash change*/
        $(window).bind('hashchange', function () {
            Event.load();
        });
        /*window scroll event*/
        $(window).scroll(function () {
            scrolltoloadrecord($("#load_more_record"));
        });
        this.hash = typeof window.location.hash != 'undefined' ? window.location.hash.replace('#', '') : "";
        if (this.hash != '') {
            Event.change_hash('page', '');
            Event.reload = 'Yes';
            Event.set_hash();
        }
        Event.load();
    },
    load: function () {
        if ($('#content_loader').is(':visible')) {
            return false;
        }
        $('#content_loader').show();
        this.set_hash();
        var params = {
            page: Event.page,
        };
        $.ajax({
            url: HTTP_ROOT + "content/ajax_event_list",
            data: params,
            method: 'post',
            success: function (response) {
                var _animated_css = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";
                if (params.page > 1) {
                    $('#content_box').append(response);
                } else {
                    $('#content_box').html(response);
                }
                $('#content_loader').hide();


                $("#load_more_record").click(function () {
                    $(this).remove();
                    var page = Math.floor($('.viewitems').size() / EVENT_SEARCH_PAGE_LIMIT);
                    Event.change_hash('page', page + 1);
                });


                $("img.lazy").lazyload({effect: "fadeIn"}).removeClass("lazy");
                var anime_class = (Event.view == 'list') ? 'effects_list' : 'effects_grid';
                $('#content_box').find("." + anime_class).addClass('animated zoomIn').one(_animated_css, function () {
                    $('#content_box').find("." + anime_class).removeClass('animated zoomIn ' + anime_class);
                });
            }
        });
    },
    change_hash: function (opt, data, id) {
        //console.log(opt+" >> "+ data+" >> "+ id);
        if (opt == 'keyword') {
            //data = data.split(' ').join('+');
            data = data.replace(/[\+]+/g, '%2B');
            data = data.replace(/[\s]+/g, '+');
        }
        var hash = typeof window.location.hash != 'undefined' ? window.location.hash.replace('#', '') : "";
        $hash = hash.split('|');
        var new_hash = new Array();
        var _temp = new Array();
        var found = false;

        //console.log($.inArray('ctype=private',$hash));
        $.each($hash, function (key, val) {
            $val = val.split('=');
            if ($val[0] !== 'page' && $val[0] != '') {
                if ($val[0] === opt) {
                    found = true;
                    new_hash.push($val[0] + "=" + data);
                } else if (typeof $val[1] != 'undefined' && $val[1] != '') {
                    new_hash.push(val);
                }
            }

        });

        //console.log(new_hash);
        if (!found && data != '') {
            new_hash.push(opt + "=" + data);
        }

        //console.log(new_hash)
        Event.page = 1;
        //new_hash.push("page=1");
        window.location.hash = new_hash.join('|');
    },
    set_hash: function () {
        var hash = typeof window.location.hash != 'undefined' ? window.location.hash.replace('#', '') : "";
        $hash = hash.split('|');

        this.reset('reset');
        $.each($hash, function (key, val) {
            if (val.trim() != '') {
                $val = val.split('=');
                var def_selected = new Array();
                switch ($val[0]) {
                    case 'page' :
                        Event.page = $val[1];
                        break;
                    case 'keyword' :
                        $('#keyword').val(decodeURIComponent($val[1].replace(/[\+]+/g, ' ')));
                        Event.keyword = $val[1];
                        break;
                }
            }
        });
    },
    get_hash: function (item) {
        var hash = typeof window.location.hash != 'undefined' ? window.location.hash.replace('#', '') : "";
        $hash = hash.split('|');
        $val = [];
        $.each($hash, function (key, val) {
            if (val.trim() != '') {
                $val = val.split('=');
                if ($val[0] == item) {
                    return false;
                }
            }
        });
        return typeof $val[1] != 'undefined' && $val[0] == item ? $val[1] : '';
    },
    reset: function (mode) {
        this.page = '1';
    }
};
jQuery(document).ready(function () {
    Event.init();
});
