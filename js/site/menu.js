$(document).ready(function () {
    var client_w=document.body.clientWidth;
    var all_width = 0;
    var all_margin = 48;
    $('ul.menu_start a').each(function(i,elem) {
        if ($(this).hasClass("a")) {
            all_width += $(this).width();
        }
    });
    var _new_offset = ~~(client_w - (all_margin + all_width))/2;
    $('ul.menu_start').offset({left:_new_offset});

    $('.btn-default.menu_start').hover(function(){
        $('#sub').css('height',70+'px');
    },
        function(){
            $('#sub').css('height',0+'px');
        }
    );
    $('#more').hide();
    var client_w=document.body.clientWidth;
    if(client_w < 1370){
        $('.sol').hide();
        $('#more').removeClass('hidden');
    }

    $(window).resize(function() {
        var client_w=document.body.clientWidth;
        if(client_w < 1600){
            $('.sol').hide();
            $('#more').show();
        }
        if(client_w > 1600){
            $('.sol').show();
            $('#more').hide();
        }
    });
});
