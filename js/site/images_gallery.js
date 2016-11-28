$(document).ready(function () {
    var max_images_g = $("span#max_images").data('max_file');
    $("img.click_photo").click(function () {
        var src_img = this.src;
        $("img.show_image").attr('src', src_img);
        setTimeout(function () {
            $("#photoModal").modal();
        }, 100);
    });
    $("img.gallery_img").click(function () {
        var src_img_big = this.src;
        var id_img_big = this.id;
        $("img.click_photo").attr('src', src_img_big);
        $("img.click_photo").attr('id', id_img_big);
        set_border(id_img_big);
    });
    $("a.p_left").click(function () {
        var id_img_big_c = $("img.click_photo").attr('id');
        if(id_img_big_c > 0){
            --id_img_big_c;
        }
        else{
            id_img_big_c = max_images_g - 1;
        }
        var src_result = $("img#"+ id_img_big_c +".gallery_img").attr('src');
        $("img.click_photo").attr('id', id_img_big_c);
        $("img.click_photo").attr('src', src_result);
        set_border(id_img_big_c);
    });
    $("a.p_right").click(function () {
        var id_img_big_c = $("img.click_photo").attr('id');
        if(id_img_big_c < max_images_g -1){
            ++id_img_big_c;
        }
        else{
            id_img_big_c = 0;
        }
        var src_result = $("img#"+ id_img_big_c +".gallery_img").attr('src');
        $("img.click_photo").attr('id', id_img_big_c);
        $("img.click_photo").attr('src', src_result);
        set_border(id_img_big_c);
    });
    function set_border(id_img_big) {
        $("img.gallery_img").removeClass("gallery_img_border");
        $("img#"+id_img_big+".gallery_img").addClass("gallery_img_border");
    }
});