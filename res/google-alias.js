/**
 * javascript
 * @license GNU LGPL Ver 3.0
 * @package google-alias
 * @author celend
 * @date 14-10-15
 */
$( document ).ready(function(){
    $('#tool-btn').on('click', function(e){
        $('.tool-al').hide();
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
        $('.tool-al').not('#tool-'+type).hide();
        if(type == 'num'){
            var num = $('#tool-'+type);
            if(num.is(':visible'))
                num.hide();
            else
                num.show();
            $('body').one('click', function(e){
                num.hide();
            })
            return false;
        }
        else if(type == 'time'){
            var time = $('#tool-'+type);
            if(time.is(':visible'))
                time.hide();
            else
                time.show();
            $('body').one('click', function(e){
                time.hide();
            })
            return false;
        }
    });
})