$(document).ready(function () {
    var client_w=document.body.clientWidth;

    var a = $('ul.menu_start').offset().left;
    var _ul = client_w - 2*170;
    var _offset = $('ul.menu_start li:nth-child(2)').offset().left - $('ul.menu_start').offset().left - 170;
    var _count = ~~(_ul/170);
    _ul = client_w - 2*170 - (_count-1)*_offset;
    var _count = ~~(_ul/170);

    var _new_offset = (client_w - (_count-1)*_offset - _count*170)/2;
    $('ul.menu_start').offset({left:_new_offset});

    $.ajax({
        url: 'site/index',
        method: 'post',
        dataType: 'json',
        data: {counts:_count},
    });
    alert(_new_offset);
});