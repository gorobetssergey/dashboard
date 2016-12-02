$(document).ready(function () {
   $("li.ul_menu").hover(function () {
       var id_menu = $(this).attr('id');
       $("div.ul_more").addClass('hide') //hide all menu
       // $("div.sub_menu_all").addClass('hide');
       $("#sub_menu"+ id_menu + ".sub_menu").removeClass('hide');
   },
       function () {
           $(".sub_menu").hover(
               function () {
               },

               function () {
                   $(".sub_menu").addClass('hide');
               });

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
    if(max_show >= count_menu){ //hide More if all button is show
        $("#-1.ul_menu").addClass('hide');
    }
    $("div.display_menu").addClass("position_finish");
    // Hover to button More
    $("li#-1.ul_menu").hover(
        function () {
        // $(".sub_menu").slideUp(0); // hide main menu
        //forming more menu
        for(var k = 0; k < max_show; k++){
            $("#-"+ k + ".ul_menu_all").addClass('hide');
        }
        $(".sub_menu_all").removeClass('hide');
        },
        function () {
            $(".sub_menu_all").hover(
            function () {

            },

            function () {
                $(".sub_menu_all").addClass('hide');
            });

        }
    );

});