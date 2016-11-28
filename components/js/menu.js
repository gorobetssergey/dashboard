$(document).ready(function () {
   $("li.ul_menu").hover(function () {
       var id_menu = $(this).attr('id');
       $("#sub_menu"+ id_menu).slideDown(200);
   });
    $(".ul_menu").mouseout(function () {
        $("div.sub_menu").slideUp(5);
    });
    $(".sub_menu").mouseout(function () {
        $(".sub_menu").slideToggle(0);
    });
    /**
     * hover to sub li
     */
    $("li.li_sub_style").hover(function () {
       $(this).find("img.img_sub").attr('src', '/images/site/menu/sub_menu/laptop2.png');
    });
    $("li.li_sub_style").mouseout(function () {
        $(this).find("img.img_sub").attr('src', '/images/site/menu/sub_menu/laptop.png');
    });
    /**
     * Block work with width menu
     */
    var count_menu = $(".display_menu").data('count_menus');
    var width_bloc = 0;
    var current_width = 0;
    var li_width = 0;
    var li_width_more = 0;
    var max_show = 0;
    $(".ul_style").css("width", function (i, value) {
        width_bloc = parseInt(value);
    });
    $("#-1.ul_menu").css("width", function (i, value) {
        li_width_more = parseInt(value);
    });
    for(var j=0; j < count_menu; j++){
        $("#"+ j + ".ul_menu").css("width", function (i, li_w) {
            current_width += li_width = parseInt(li_w);
            if(Number(current_width + li_width_more ) < width_bloc){
                max_show ++;
            }
        });
    }
    $("div.display_menu").removeClass("position_finish");
    for(var k = count_menu; k >= max_show; k--){
        $("#"+ k + ".ul_menu").hide();
    }
    $("div.display_menu").addClass("position_finish");
});