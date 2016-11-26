$(document).ready(function () {
    $('#transport').hover(function(){
            var _width = $('#transport_first').width();
            var _heigth = $('#transport_first').height();
            $('#transport_first').slideUp('fast');
            $('#transport_new').slideDown('slow');
            $('.mem').height('auto');

            $('#transport_new').hover(
                function(){

                },
                function(){
                    $('#transport_new').hide('fast');
                    $('#transport_first').show('slow');
                }
            );
        },
        function(){

        }
    );
    $('#real_state').hover(function(){
            var _width = $('#real_state_first').width();
            var _heigth = $('#real_state_first').height();
            $('#real_state_first').slideUp('fast');
            $('#real_state_new').slideDown('slow');
            $('.mem').height('auto');

            $('#real_state_new').hover(
                function(){

                },
                function(){
                    $('#real_state_new').hide('fast');
                    $('#real_state_first').show('slow');
                }
            );
        },
        function(){

        }
    );
});
