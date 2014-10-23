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
            $('#search-info').animate({
                'top': '-30px'
            }, 300, function(){
                $(this).hide();
                $('#tool-panel').show().animate({
                    'top':0
                },100);
            });
            $(this).removeClass('tool-btn').addClass('tool-btn-press');
        }
        else{
            $('#tool-btn').removeClass('tool-btn-press').addClass('tool-btn');
            $('#tool-panel').animate({
                'top': '30px'
            }, 300, function(){
                $(this).hide();
                $('#search-info').show().animate({
                    'top': 0
                }, 100);
            })
        }
    })
})