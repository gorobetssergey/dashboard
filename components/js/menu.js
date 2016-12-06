$(document).ready(function () {
    var between_button_menu = 4;
    var pointer_half = 10; // half width with 20px
   $("li.ul_menu").hover(function () {
       var id_menu = $(this).attr('id');
       var pointer_position = sub_menu_left_style;
       $("div.ul_more").addClass('hide'); //hide all menu
       // $("div.sub_menu_all").addClass('hide');
       $("#sub_menu"+ id_menu + ".sub_menu").removeClass('hide');
           var j=0;
           for(j=0; j <= id_menu; j++){
               $("#"+ j + ".ul_menu").css("width", function (i, li_w) {
                   if(j == id_menu){
                       var x = parseInt(li_w);
                       pointer_position += x/2;
                       console.log(pointer_position);
                   }
                   else{
                       pointer_position += li_width = parseInt(li_w);
                       pointer_position += between_button_menu;
                       console.log(pointer_position);
                   }

               });
           }
           pointer_position -= pointer_half;
           $("div.pointer").css('left', pointer_position+'px');
           $("div.pointer_main").css('left', pointer_position+'px');
           pointer_position = sub_menu_left_style;
       $("div.pointer").removeClass('hide');
       $("div.pointer_main").removeClass('hide');
   },
       function () {
           $(".sub_menu").hover(
               function () {
               },

               function () {
                   $(".sub_menu").addClass('hide');
                   $("div.pointer").addClass('hide');
                   $("div.pointer_main").addClass('hide');
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
    var width_page = 0;
    var sub_menu_left_style = 0;
    $(".ul_style").css("width", function (i, value) {
        width_bloc = parseInt(value);
    });
    $("div.width_page").css('width', function (i, value) {
        width_page = parseInt(value);
        sub_menu_left_style = (width_page * 0.05) + Number(between_button_menu);
    });
    $("div.sub_menu_left_style").css('width', sub_menu_left_style); // set width block he have function hide element with left
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
    //Click on sub menu button left right
    $("span.excess_sub_menu").click(function () {
        var id_status = $(this).attr("id");
        var width_one_button = 0;
            $("li#0.ul_sub_menu").css('width',  function (i, one_menu) {
                width_one_button = parseInt(one_menu);
        });
        var width_left = 0;
        if(id_status == 0) {
            $("#0.excess_sub_menu").addClass('hide');
            $("#1.excess_sub_menu").removeClass('hide');
             width_left = max_show * Number(width_one_button + between_button_menu); // 4px width between button
            $(".ul_sup").animate({
                left: '-' + width_left + 'px'
            });
        }
        else {
            $(".ul_sup").animate({
                left: '+' + width_left + 'px'
            },
            function () {
                $("#1.excess_sub_menu").addClass('hide');
                $("#0.excess_sub_menu").removeClass('hide');
            });
        }
    });
});