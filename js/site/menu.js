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
            real_estate(this.id);
    },
        function(){
            $('#sub').hover(function(){
                    $('#sub').css('height',70+'px');
                },
                function() {
                    $('#sub').empty();
                    $('#sub').css('height', 0 + 'px');
                });
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

    function real_estate(id)
    {
        switch (id){
            case 'real_state' : $('#sub').html(function(){
                                return '' +
                                    '<div class="btn-group btn-group-justified" role="group" aria-label="...">' +
                                        '<div class="btn-group" role="group">' +
                                            '<a href="" type="button" class="btn btn-default inner_menu" style="border: none; line-height: 40px; height: 50px;" id = "arenda">Аренда</a>' +
                                        '</div>' +
                                        '<div class="btn-group" role="group">' +
                                            '<a href="" type="button" class="btn btn-default inner_menu" id = "prodaja">Продажа</a>' +
                                        '</div>' +
                                        '<div class="btn-group" role="group">' +
                                            '<a href="" type="button" class="btn btn-default inner_menu" id = "obmen">Обмен</a>' +
                                        '</div>' +
                                        '<div class="btn-group" role="group">' +
                                            '<a href="" type="button" class="btn btn-default inner_menu" id = "prochee">Прочее</a>' +
                                        '</div>' +
                                    '</div>'
                            });break;
            case 'transport' : $('#sub').html(function(){
                                return '<h3>transport</h3>'
                            });break;
        }
    }
});
