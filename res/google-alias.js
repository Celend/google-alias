/**
 * javascript
 * @license GNU LGPL Ver 3.0
 * @package google-alias
 * @author celend
 * @date 14-10-15
 */
$( document ).ready(function(){
    $('#tool-btn').on('click', function(e){
        if($('#search-info').is(':visible')){
            $('#search-info').stop().animate({
                'top': '-30px'
            }, 150, function(){
                $(this).hide();
                $('#tool-panel').show().animate({
                    'top':0
                },75, function(){
                    $('.search-tool-bar').css('overflow', 'visible');
                });
            });
            $(this).removeClass('tool-btn').addClass('tool-btn-press');
        }
        else{
            $('.search-tool-bar').css('overflow', 'hidden');
            $('#tool-btn').removeClass('tool-btn-press').addClass('tool-btn');
            $('#tool-panel').stop().animate({
                'top': '30px'
            }, 150, function(){
                $(this).hide();
                $('#search-info').show().animate({
                    'top': 0
                }, 75);
            })
        }
    });
    $('.tool').on('click', function(e){
        var type = $(this).attr('id');

        if(type == 'num'){
            $('#tool-time').hide();
            var num = $('#tool-'+type).show();
            $('body').one('click', function(e){
                num.hide();
            })
            return false;
        }
        else if(type == 'time'){
            $('#tool-num').hide();
            var time = $('#tool-'+type).show()
            $('body').one('click', function(e){
                time.hide();
            })
            return false;
        }
    });
})