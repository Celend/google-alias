/**
 * javascript
 * @license GNU LGPL Ver 3.0
 * @package google-alias
 * @author celend
 * @date 14-10-15
 */
$( document ).ready(function(){
    $('.tool-btn').on('click', function(e){
        $('.tool-al').hide();
        if(!$('#tool-panel').is(':visible')){
            $(this).removeClass('tool-btn').addClass('tool-btn-press');
            $('#tool-panel').show();
            $('#search-info').animate({
                'marginTop': '-40px'
            }, 150);
        }
        else{
            $(this).removeClass('tool-btn-press').addClass('tool-btn');
            $('#search-info').animate({
                'marginTop': 0
            }, 150, function(){
                $('#tool-panel').hide();
            });
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
            });
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
            });
            return false;
        }
    });
});