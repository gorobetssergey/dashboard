$(document).ready(function () {
    window.addEventListener('resize', function(event){
        WindowResize();
    });
    var between_button_menu = 4;
    var pointer_half = 10; // half width with 20px
    var max_show_sub = 0;
   $("li.ul_menu").hover(function () {
       var id_menu = $(this).attr('id');
       if(id_menu < 0){ //if hover to left right, will be return
           return false;
       }
       // var id_menu_store = id_menu;
       var pointer_position = sub_menu_left_style;
       $("div.ul_more").addClass('hide'); //hide all menu
       $("div.sub_menu_all").addClass('hide'); //hide main menu
       $(".sub_menu").addClass('hide'); // hide main menu


           $("#sub_menu"+ id_menu + ".sub_menu").removeClass('hide');   //show sub_menu
           max_show_sub = maxShowSub(id_menu);

       var for_max =  id_menu;
       if(id_menu == '-1'){
           for_max = max_show - 1;
       }

       logicPointer(id_menu, for_max, pointer_position, current_width);
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
    },
    function () {
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
    current_width = WindowResize();
    console.log(current_width);
    $("li.ul_menu.menu_right").click(function () {
        var id = $(this).data("left_right");
        console.log(id);
        menuLeftRight(id, current_width);
    });
    // Hover to button More
    // $("li#-1.ul_menu").hover(
    //     function () {
    //     $(".sub_menu").addClass('hide'); // hide main menu
    //     //forming more menu
    //     for(var k = 0; k < max_show; k++){
    //         $("#-"+ k + ".ul_menu_all").addClass('hide');
    //     }
    //     $(".sub_menu_all").removeClass('hide');
    //     },
    //     function () {
    //         $(".sub_menu_all").hover(
    //         function () {
    //
    //         },
    //
    //         function () {
    //             $(".sub_menu_all").addClass('hide');
    //             $("div.pointer").addClass('hide');
    //             $("div.pointer_main").addClass('hide');
    //         });
    //
    //     }
    // );
    //Click on sub menu button left right
    $("span.excess_sub_menu").click(function () {
        var id_status = $(this).attr("id");
        subMenuLeftRight(id_status, current_width);
    });

    //library
    function WindowResize() {
        width_bloc = 0;
        current_width = 0;
        li_width = 0;
        li_width_more = 0;
        max_show = 0;
        width_page = 0;
        sub_menu_left_style = 0;
        $(".ul_menu").removeClass("hide");

        $(".width_page").css("width", function (i, value) {
            width_bloc = parseInt(value)*0.95;
        });
        // $("div.width_page").css('width', function (i, value) {
        //     width_page = parseInt(value);
        //     sub_menu_left_style = (width_page * 0.05) + Number(between_button_menu);
        // });
        // $("div.sub_menu_left_style").css('width', sub_menu_left_style); // set width block he have function hide element with left
        $("li#-1.ul_menu").css("width", function (i, value) {
            li_width_more = parseInt(value);
        });
        for(var j = 0; j < count_menu; j++) {
            if (Number(current_width + li_width_more) < width_bloc && (j < count_menu-3)) {
                max_show++;
                $("#" + j + ".ul_menu").css("width", function (i, li_w) {
                    current_width += li_width = parseInt(li_w);
                });
            }
            else{
                break;
            }
        }
        // $("div.display_menu").removeClass("position_finish");
        // for (var k = count_menu; k >= max_show; k--) {
        //     $("#" + k + ".ul_menu").addClass('hide');
        // }
        if (max_show >= count_menu) { //hide More if all button is show
            $("#-1.ul_menu").addClass('hide');
        }
        // $("div.display_menu").addClass("position_finish");
        return current_width +  (current_width * 0.04) + between_button_menu;
    }

    function maxShowSub(id_sub) {
        var sub_menu_width = 0;
        var sub_menu_count = $("#sub_menu"+ id_sub + ".sub_menu").find('ul.ul_sup').data('sub_menu_count');
        $("#sub_menu"+ id_sub + ".sub_menu").find('ul.ul_sup').css("width",function (i, sub) {
            sub_menu_width = parseInt(sub);
        });
        var sub_li_width = 0;
        $("#sub_menu"+ id_sub + ".sub_menu").find('li#0.ul_sub_menu').css("width",function (i, li) {
            sub_li_width = parseInt(li);
        });
        var max_to_show = Math.floor(sub_menu_width/(Number(sub_li_width + between_button_menu)));
        if(max_to_show >= sub_menu_count){
            $("#0.excess_sub_menu").addClass('hide');
        }
        else{
            $("#0.excess_sub_menu").removeClass('hide');
        }

        return max_to_show;
    }
    function logicPointer(id_menu, for_max, pointer_position, current_width) {
        pointer_position += current_width*0.02;
        for(var j=0; j <= for_max; j++){
            $("#"+ j + ".ul_menu").css("width", function (i, li_w) {
                if(j == id_menu){
                    var x = parseInt(li_w);
                    pointer_position += x/2;
                }
                else{
                    pointer_position += li_width = parseInt(li_w);
                    pointer_position += between_button_menu;
                }

            });
        }
        if(id_menu == '-1') {
            var width_more = 0;
            $("#-1.ul_menu").css("width", function (i, li_more) {
                width_more = parseInt(li_more);
            });
            pointer_position += between_button_menu;
            pointer_position += width_more/2;
        }
        pointer_position -= pointer_half;

        $("div.pointer").css('left', pointer_position+'px');
        $("div.pointer_main").css('left', pointer_position+'px');
        pointer_position = sub_menu_left_style;
        $("div.pointer").removeClass('hide');
        $("div.pointer_main").removeClass('hide');
    }
    function subMenuLeftRight(id_status) {
        var width_one_button = 0;
        $("li#0.ul_sub_menu").css('width',  function (i, one_menu) {
            width_one_button = parseInt(one_menu);
        });
        var width_left = 0;
        if(id_status == 0) {
            $("#0.excess_sub_menu").addClass('hide');
            $("#1.excess_sub_menu").removeClass('hide');
            width_left = Number(max_show_sub) * Number(width_one_button + between_button_menu); // 4px width between button
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
    }
    function menuLeftRight(id, current_width) {
       var id_max=0;
       var max=0;
        console.log(current_width);
       $(".display_menu").find("li.menu_count").each(function () {
          id_max = Number(Math.max(this.id, max)+1); // +1 counting id=0
       });
        if(id =='right'){
            $("div.display_menu").animate({
                left: '-' + current_width  + 'px'
            });
            $("li.menu_right").removeClass('glyphicon-menu-right');
            $("li.menu_right").addClass('glyphicon-menu-left');
            $("li.menu_right").data("left_right", "left");
        }
        else if(id =='left'){
            $("div.display_menu").animate({
                left: '+' + 0  + 'px'
            });
            $("li.menu_right").removeClass('glyphicon-menu-left');
            $("li.menu_right").addClass('glyphicon-menu-right');
            $("li.menu_right").data("left_right", "right");
        }
    }
});